<?php
require_once __DIR__ . "/../models/Direccion.php";

class DireccionController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];

        $direcciones = Direccion::obtenerPorUsuario($id_usuario);

        require_once __DIR__ . "/../views/direcciones/direcciones.php";
    }

    public function crear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        require_once __DIR__ . "/../views/direcciones/crear.php";
    }

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_usuario = $_SESSION["usuario"]["id_usuario"];

            $nombre_destinatario = trim($_POST["nombre_destinatario"]);
            $direccion = trim($_POST["direccion"]);
            $ciudad = trim($_POST["ciudad"]);
            $provincia = trim($_POST["provincia"]);
            $codigo_postal = trim($_POST["codigo_postal"]);
            $pais = trim($_POST["pais"]);
            $telefono = trim($_POST["telefono"]);
            $principal = isset($_POST["principal"]) ? 1 : 0;

            Direccion::crear(
                $id_usuario,
                $nombre_destinatario,
                $direccion,
                $ciudad,
                $provincia,
                $codigo_postal,
                $pais,
                $telefono,
                $principal
            );

            header("Location: index.php?controller=direccion&action=index");
            exit;
        }
    }

    public function editar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];
        $id_direccion = $_GET["id"] ?? null;

        if (!$id_direccion) {
            header("Location: index.php?controller=direccion&action=index");
            exit;
        }

        $direccion = Direccion::obtenerPorId($id_direccion, $id_usuario);

        if (!$direccion) {
            header("Location: index.php?controller=direccion&action=index");
            exit;
        }

        require_once __DIR__ . "/../views/direcciones/editar.php";
    }

    public function actualizar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_usuario = $_SESSION["usuario"]["id_usuario"];
            $id_direccion = $_POST["id_direccion"];

            $nombre_destinatario = trim($_POST["nombre_destinatario"]);
            $direccion = trim($_POST["direccion"]);
            $ciudad = trim($_POST["ciudad"]);
            $provincia = trim($_POST["provincia"]);
            $codigo_postal = trim($_POST["codigo_postal"]);
            $pais = trim($_POST["pais"]);
            $telefono = trim($_POST["telefono"]);
            $principal = isset($_POST["principal"]) ? 1 : 0;

            Direccion::actualizar(
                $id_direccion,
                $id_usuario,
                $nombre_destinatario,
                $direccion,
                $ciudad,
                $provincia,
                $codigo_postal,
                $pais,
                $telefono,
                $principal
            );

            header("Location: index.php?controller=direccion&action=index");
            exit;
        }
    }

    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];
        $id_direccion = $_GET["id"] ?? null;

        if ($id_direccion) {
            Direccion::eliminar($id_direccion, $id_usuario);
        }

        header("Location: index.php?controller=direccion&action=index");
        exit;
    }

    public function principal() {
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];
        $id_direccion = $_GET["id"] ?? null;

        if ($id_direccion) {
            Direccion::hacerPrincipal($id_direccion, $id_usuario);
        }

        header("Location: index.php?controller=direccion&action=index");
        exit;
    }
}
?>