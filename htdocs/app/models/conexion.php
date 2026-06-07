<?php
require_once __DIR__ . "/../../app/config/config.php";

class Conexion {
    public static function conectar() {
        try {
            $pdo = new PDO(
                "mysql:host=" . Config::$host . ";dbname=" . Config::$db . ";charset=" . Config::$charset,
                Config::$user,
                Config::$pass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            if (Config::$env === "development") {
                die("Error de conexión: " . $e->getMessage());
            } else {
                die("Error de conexión. Por favor, inténtelo más tarde.");
            }
        }
    }
}
?>