<?php

require_once __DIR__ . "/conexion.php";

class Categoria {

    public static function obtenerTodas() {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM categorias ORDER BY nombre ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crear($nombre) {
        $db = Conexion::conectar();

        $sql = "INSERT INTO categorias (nombre)
                VALUES (:nombre)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);

        return $stmt->execute();
    }

    public static function eliminar($id_categoria) {
        $db = Conexion::conectar();

        $sql = "DELETE FROM categorias
                WHERE id_categoria = :id_categoria";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);

        return $stmt->execute();
    }
}