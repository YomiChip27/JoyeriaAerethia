<?php
require_once __DIR__ . "/conexion.php";

class Pedido {

    public static function obtenerPorUsuario($id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT 
                    p.id_pedido,
                    p.fecha_pedido,
                    p.total,
                    p.estado,
                    d.direccion,
                    d.ciudad,
                    d.provincia,
                    d.codigo_postal
                FROM pedidos p
                INNER JOIN direcciones d 
                    ON p.id_direccion = d.id_direccion
                WHERE p.id_usuario = :id_usuario
                ORDER BY p.fecha_pedido DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerDetalle($id_pedido, $id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT 
                    dp.id_detalle,
                    pr.nombre,
                    pr.imagen,
                    dp.cantidad,
                    dp.precio_unitario,
                    (dp.cantidad * dp.precio_unitario) AS subtotal
                FROM detalle_pedido dp
                INNER JOIN productos pr 
                    ON dp.id_producto = pr.id_producto
                INNER JOIN pedidos p 
                    ON dp.id_pedido = p.id_pedido
                WHERE dp.id_pedido = :id_pedido
                AND p.id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_pedido", $id_pedido);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function contar() {
            $db = Conexion::conectar();

            $sql = "SELECT COUNT(*) as total FROM pedidos";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"];
        }

        public static function obtenerTodos($buscar = null, $inicio = null, $limite = null) {
            $db = Conexion::conectar();

            $sql = "SELECT
                        pedidos.*,
                        usuarios.nombre,
                        usuarios.apellidos,
                        usuarios.email
                    FROM pedidos
                    INNER JOIN usuarios
                        ON pedidos.id_usuario = usuarios.id_usuario
                    WHERE 1 = 1";

            if (!empty($buscar)) {
                $sql .= " AND (
                            pedidos.id_pedido LIKE :buscar
                            OR usuarios.nombre LIKE :buscar
                            OR usuarios.apellidos LIKE :buscar
                            OR usuarios.email LIKE :buscar
                            OR pedidos.estado LIKE :buscar
                        )";
            }

            $sql .= " ORDER BY pedidos.fecha_pedido DESC";

            if ($inicio !== null && $limite !== null) {
                $sql .= " LIMIT :inicio, :limite";
            }

            $stmt = $db->prepare($sql);

            if (!empty($buscar)) {
                $buscarParam = "%" . $buscar . "%";
                $stmt->bindParam(":buscar", $buscarParam);
            }

            if ($inicio !== null && $limite !== null) {
                $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
                $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerDetalleAdmin($id_pedido) {
             $db = Conexion::conectar();

            $sql = "SELECT 
                        dp.id_detalle,
                        pr.nombre,
                        pr.imagen,
                        dp.cantidad,
                        dp.precio_unitario,
                        (dp.cantidad * dp.precio_unitario) AS subtotal
                    FROM detalle_pedido dp
                    INNER JOIN productos pr 
                        ON dp.id_producto = pr.id_producto
                    WHERE dp.id_pedido = :id_pedido";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_pedido", $id_pedido);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerPedidoAdmin($id_pedido) {
            $db = Conexion::conectar();

            $sql = "SELECT 
                        p.id_pedido,
                        p.fecha_pedido,
                        p.total,
                        p.estado,
                        u.nombre,
                        u.apellidos,
                        u.email,
                        d.direccion,
                        d.ciudad,
                        d.provincia,
                        d.codigo_postal
                    FROM pedidos p
                    INNER JOIN usuarios u 
                        ON p.id_usuario = u.id_usuario
                    INNER JOIN direcciones d 
                        ON p.id_direccion = d.id_direccion
                    WHERE p.id_pedido = :id_pedido";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id_pedido", $id_pedido);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public static function actualizarEstado($id_pedido, $nuevo_estado) {
            $db = Conexion::conectar();

            $sql = "UPDATE pedidos SET estado = :estado WHERE id_pedido = :id_pedido";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":estado", $nuevo_estado);
            $stmt->bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public static function crearPedido($id_usuario, $id_direccion, $total, $carrito) {
            $db = Conexion::conectar();

            try {
                $db->beginTransaction();

                $sqlPedido = "INSERT INTO pedidos 
                            (id_usuario, id_direccion, total, estado)
                            VALUES 
                            (:id_usuario, :id_direccion, :total, 'pendiente')";

                $stmt = $db->prepare($sqlPedido);
                $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(":id_direccion", $id_direccion, PDO::PARAM_INT);
                $stmt->bindParam(":total", $total);
                $stmt->execute();

                $id_pedido = $db->lastInsertId();

                foreach ($carrito as $item) {

                    $sqlDetalle = "INSERT INTO detalle_pedido
                                (id_pedido, id_producto, cantidad, precio_unitario)
                                VALUES
                                (:id_pedido, :id_producto, :cantidad, :precio_unitario)";

                    $stmtDetalle = $db->prepare($sqlDetalle);
                    $stmtDetalle->bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);
                    $stmtDetalle->bindParam(":id_producto", $item["id_producto"], PDO::PARAM_INT);
                    $stmtDetalle->bindParam(":cantidad", $item["cantidad"], PDO::PARAM_INT);
                    $stmtDetalle->bindParam(":precio_unitario", $item["precio"]);
                    $stmtDetalle->execute();

                    $sqlStock = "UPDATE productos
                                SET stock = stock - :cantidad
                                WHERE id_producto = :id_producto
                                AND stock >= :cantidad";

                    $stmtStock = $db->prepare($sqlStock);
                    $stmtStock->bindParam(":cantidad", $item["cantidad"], PDO::PARAM_INT);
                    $stmtStock->bindParam(":id_producto", $item["id_producto"], PDO::PARAM_INT);
                    $stmtStock->execute();

                    if ($stmtStock->rowCount() == 0) {
                        throw new Exception("Stock insuficiente");
                    }
                }

                $db->commit();

                return $id_pedido;

            } catch (Exception $e) {
                $db->rollBack();
                return false;
            }
        }
        public static function contarTodosFiltrados($buscar = null) {
            $db = Conexion::conectar();

            $sql = "SELECT COUNT(*) AS total
                    FROM pedidos
                    INNER JOIN usuarios
                        ON pedidos.id_usuario = usuarios.id_usuario
                    WHERE 1 = 1";

            if (!empty($buscar)) {
                $sql .= " AND (
                            pedidos.id_pedido LIKE :buscar
                            OR usuarios.nombre LIKE :buscar
                            OR usuarios.apellidos LIKE :buscar
                            OR usuarios.email LIKE :buscar
                            OR pedidos.estado LIKE :buscar
                        )";
            }

            $stmt = $db->prepare($sql);

            if (!empty($buscar)) {
                $buscarParam = "%" . $buscar . "%";
                $stmt->bindParam(":buscar", $buscarParam);
            }

            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"];
        }
    }
?>