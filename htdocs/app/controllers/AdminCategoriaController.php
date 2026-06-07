<?php

require_once __DIR__ . "/../models/Categorias.php";

class AdminCategoriaController {

    private function comprobarAdmin() {
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "admin") {
            header("Location: index.php");
            exit;
        }
    }

    public function index() {
        $this->comprobarAdmin();

        $categorias = Categoria::obtenerTodas();

        require_once __DIR__ . "/../views/admin/categorias/index.php";
    }

    public function crear() {
        $this->comprobarAdmin();

        require_once __DIR__ . "/../views/admin/categorias/crear.php";
    }

    public function guardar() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (!empty($nombre)) {
                Categoria::crear($nombre);

                $_SESSION["mensaje"] = "Categoría creada correctamente.";
                $_SESSION["tipo"] = "success";
            }
        }

        header("Location: index.php?controller=adminCategoria&action=index");
        exit;
    }

    public function eliminar() {
        $this->comprobarAdmin();

        if (isset($_GET["id"])) {
            Categoria::eliminar($_GET["id"]);

            $_SESSION["mensaje"] = "Categoría eliminada correctamente.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=adminCategoria&action=index");
        exit;
    }
}

?>