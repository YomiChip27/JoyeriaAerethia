<?php

require_once __DIR__ . "/conexion.php";

class Reserva {

    public static function crear($id_usuario, $id_producto) {

        $db = Conexion::conectar();

        $sql = "INSERT INTO reservas
                (id_usuario, id_producto, estado)
                VALUES
                (:id_usuario, :id_producto, 'activa')";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }

            throw $e;
        }
    }

    public static function obtenerPorUsuario($id_usuario) {

        $db = Conexion::conectar();

        $sql = "SELECT
                    reservas.*,
                    productos.nombre,
                    productos.precio,
                    productos.imagen
                FROM reservas
                INNER JOIN productos
                    ON reservas.id_producto = productos.id_producto
                WHERE reservas.id_usuario = :id_usuario
                ORDER BY reservas.fecha_reserva DESC";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPendientesPagoPorUsuario($id_usuario) {

        $db = Conexion::conectar();

        $sql = "SELECT
                    reservas.*,
                    productos.nombre,
                    productos.precio,
                    productos.imagen
                FROM reservas
                INNER JOIN productos
                    ON reservas.id_producto = productos.id_producto
                WHERE reservas.id_usuario = :id_usuario
                AND reservas.estado = 'pendiente_pago'
                ORDER BY reservas.fecha_limite_pago ASC";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function contarReservasPorProducto($id_producto) {

        $db = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total
                FROM reservas
                WHERE id_producto = :id_producto
                AND estado IN ('activa', 'pendiente_pago')";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado["total"];
    }

    public static function existeReservaUsuario($id_usuario, $id_producto){

        $db = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total
                FROM reservas
                WHERE id_usuario = :id_usuario
                AND id_producto = :id_producto
                AND estado IN ('activa', 'pendiente_pago')";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado["total"] > 0;
    }

    public static function cancelar($id_reserva, $id_usuario) {

        $db = Conexion::conectar();

        $sql = "UPDATE reservas
                SET estado = 'cancelada',
                    fecha_limite_pago = NULL
                WHERE id_reserva = :id_reserva
                AND id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function obtenerTodas() {

        $db = Conexion::conectar();

        $sql = "SELECT
                    r.id_reserva,
                    r.fecha_reserva,
                    r.estado,
                    r.fecha_limite_pago,
                    u.nombre AS nombre_usuario,
                    u.apellidos,
                    u.email,
                    p.nombre AS nombre_producto,
                    p.imagen
                FROM reservas r
                INNER JOIN usuarios u
                    ON r.id_usuario = u.id_usuario
                INNER JOIN productos p
                    ON r.id_producto = p.id_producto
                ORDER BY r.fecha_reserva DESC";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cambiarEstado($id_reserva, $nuevo_estado) {

        $db = Conexion::conectar();

        if ($nuevo_estado == "pendiente_pago") {

            $sql = "UPDATE reservas
                    SET estado = :nuevo_estado,
                        fecha_limite_pago = DATE_ADD(NOW(), INTERVAL 48 HOUR)
                    WHERE id_reserva = :id_reserva";

        } else {

            $sql = "UPDATE reservas
                    SET estado = :nuevo_estado,
                        fecha_limite_pago = NULL
                    WHERE id_reserva = :id_reserva";
        }

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":nuevo_estado", $nuevo_estado, PDO::PARAM_STR);
        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function cancelarReservasCaducadas() {

        $db = Conexion::conectar();

        $sql = "UPDATE reservas
                SET estado = 'cancelada',
                    fecha_limite_pago = NULL
                WHERE estado = 'pendiente_pago'
                AND fecha_limite_pago < NOW()";

        $stmt = $db->prepare($sql);

        return $stmt->execute();
    }

    public static function obtenerReservaPorId($id_reserva) {

        $db = Conexion::conectar();

        $sql = "SELECT *
                FROM reservas
                WHERE id_reserva = :id_reserva";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function contar() {

        $db = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM reservas";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado["total"];
    }
    public static function obtenerPorId($id_reserva) {
        $db = Conexion::conectar();

        $sql = "SELECT 
                    reservas.*,
                    productos.nombre,
                    productos.precio,
                    productos.imagen
                FROM reservas
                INNER JOIN productos
                    ON reservas.id_producto = productos.id_producto
                WHERE reservas.id_reserva = :id_reserva";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>