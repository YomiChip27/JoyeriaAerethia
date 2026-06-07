<?php

require_once __DIR__ . "/conexion.php";

class ImagenProducto {

    public static function obtenerPorProducto($id_producto) {
        $db = Conexion::conectar();

        $sql = "SELECT *
                FROM imagenes_producto
                WHERE id_producto = :id_producto
                ORDER BY fecha_subida DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crear($id_producto, $imagen) {
        $db = Conexion::conectar();

        $sql = "INSERT INTO imagenes_producto
                (id_producto, imagen)
                VALUES
                (:id_producto, :imagen)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(":imagen", $imagen);

        return $stmt->execute();
    }

    public static function eliminar($id_imagen) {
        $db = Conexion::conectar();

        $sql = "DELETE FROM imagenes_producto
                WHERE id_imagen = :id_imagen";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_imagen", $id_imagen, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>