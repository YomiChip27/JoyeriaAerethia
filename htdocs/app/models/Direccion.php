<?php
require_once __DIR__ . "/conexion.php";

class Direccion {

    public static function obtenerPorUsuario($id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM direcciones 
                WHERE id_usuario = :id_usuario
                ORDER BY principal DESC, id_direccion DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crear($id_usuario, $nombre_destinatario, $direccion, $ciudad, $provincia, $codigo_postal, $pais, $telefono, $principal) {
        $db = Conexion::conectar();

        if ($principal == 1) {
            self::quitarPrincipal($id_usuario);
        }

        $sql = "INSERT INTO direcciones 
                (id_usuario, nombre_destinatario, direccion, ciudad, provincia, codigo_postal, pais, telefono, principal)
                VALUES
                (:id_usuario, :nombre_destinatario, :direccion, :ciudad, :provincia, :codigo_postal, :pais, :telefono, :principal)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->bindParam(":nombre_destinatario", $nombre_destinatario);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":ciudad", $ciudad);
        $stmt->bindParam(":provincia", $provincia);
        $stmt->bindParam(":codigo_postal", $codigo_postal);
        $stmt->bindParam(":pais", $pais);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":principal", $principal);

        return $stmt->execute();
    }

    public static function obtenerPorId($id_direccion, $id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM direcciones 
                WHERE id_direccion = :id_direccion 
                AND id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_direccion", $id_direccion);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id_direccion, $id_usuario, $nombre_destinatario, $direccion, $ciudad, $provincia, $codigo_postal, $pais, $telefono, $principal) {
        $db = Conexion::conectar();

        if ($principal == 1) {
            self::quitarPrincipal($id_usuario);
        }

        $sql = "UPDATE direcciones SET
                    nombre_destinatario = :nombre_destinatario,
                    direccion = :direccion,
                    ciudad = :ciudad,
                    provincia = :provincia,
                    codigo_postal = :codigo_postal,
                    pais = :pais,
                    telefono = :telefono,
                    principal = :principal
                WHERE id_direccion = :id_direccion
                AND id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre_destinatario", $nombre_destinatario);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":ciudad", $ciudad);
        $stmt->bindParam(":provincia", $provincia);
        $stmt->bindParam(":codigo_postal", $codigo_postal);
        $stmt->bindParam(":pais", $pais);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":principal", $principal);
        $stmt->bindParam(":id_direccion", $id_direccion);
        $stmt->bindParam(":id_usuario", $id_usuario);

        return $stmt->execute();
    }

    public static function eliminar($id_direccion, $id_usuario) {
        $db = Conexion::conectar();

        $sql = "DELETE FROM direcciones 
                WHERE id_direccion = :id_direccion
                AND id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_direccion", $id_direccion);
        $stmt->bindParam(":id_usuario", $id_usuario);

        return $stmt->execute();
    }

    public static function quitarPrincipal($id_usuario) {
        $db = Conexion::conectar();

        $sql = "UPDATE direcciones 
                SET principal = 0 
                WHERE id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);

        return $stmt->execute();
    }

    public static function obtenerPrincipal($id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM direcciones
                WHERE id_usuario = :id_usuario
                AND principal = 1
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function hacerPrincipal($id_direccion, $id_usuario) {
        $db = Conexion::conectar();

        $db->beginTransaction();

        $sql1 = "UPDATE direcciones 
                SET principal = 0 
                WHERE id_usuario = :id_usuario";

        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam(":id_usuario", $id_usuario);
        $stmt1->execute();

        $sql2 = "UPDATE direcciones 
                SET principal = 1 
                WHERE id_direccion = :id_direccion 
                AND id_usuario = :id_usuario";

        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(":id_direccion", $id_direccion);
        $stmt2->bindParam(":id_usuario", $id_usuario);
        $ok = $stmt2->execute();

        $db->commit();

        return $ok;
    }
}
?>