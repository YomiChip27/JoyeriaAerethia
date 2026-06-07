<?php

require_once __DIR__ . "/conexion.php";

class Piedra {

    public static function obtenerTodas() {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM piedras ORDER BY nombre ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crear($nombre) {
        $db = Conexion::conectar();

        $sql = "INSERT INTO piedras (nombre) VALUES (:nombre)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);

        return $stmt->execute();
    }

    public static function eliminar($id_piedra) {
        $db = Conexion::conectar();

        $sql = "DELETE FROM piedras WHERE id_piedra = :id_piedra";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_piedra", $id_piedra, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>