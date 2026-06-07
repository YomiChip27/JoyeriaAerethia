<?php

require_once __DIR__ . "/../models/Piedra.php";

class AdminPiedraController {

    private function comprobarAdmin() {
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "admin") {
            header("Location: index.php");
            exit;
        }
    }

    public function index() {
        $this->comprobarAdmin();

        $piedras = Piedra::obtenerTodas();

        require_once __DIR__ . "/../views/admin/piedras/index.php";
    }

    public function crear() {
        $this->comprobarAdmin();

        require_once __DIR__ . "/../views/admin/piedras/crear.php";
    }

    public function guardar() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (!empty($nombre)) {
                Piedra::crear($nombre);

                $_SESSION["mensaje"] = "Piedra creada correctamente.";
                $_SESSION["tipo"] = "success";
            } else {
                $_SESSION["mensaje"] = "El nombre de la piedra no puede estar vacío.";
                $_SESSION["tipo"] = "warning";
            }
        }

        header("Location: index.php?controller=adminPiedra&action=index");
        exit;
    }

    public function eliminar() {
        $this->comprobarAdmin();

        if (isset($_GET["id"])) {
            Piedra::eliminar($_GET["id"]);

            $_SESSION["mensaje"] = "Piedra eliminada correctamente.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=adminPiedra&action=index");
        exit;
    }
}

?>