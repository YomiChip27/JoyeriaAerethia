<?php

require_once __DIR__ . "/../models/Reserva.php";
require_once __DIR__ . "/../models/Producto.php";

class ReservaController{
    public function index() {

        $productos = Producto::obtenerProductosExclusivos();

        require_once __DIR__ . "/../views/reservas/index.php";
    }
    public function crear(){
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        if (!isset($_GET["id_producto"])) {
            header("Location: index.php?controller=producto&action=index");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];
        $id_producto = $_GET["id_producto"];

        $producto = Producto::obtenerPorId($id_producto);

        if ($producto["exclusivo"] != 1) {
            $_SESSION["mensaje"] = "Este producto no admite reservas.";
            $_SESSION["tipo"] = "warning";

            header("Location: index.php?controller=producto&action=detalle&id=" . $id_producto);
            exit;
        }

        if (Reserva::existeReservaUsuario($id_usuario, $id_producto)) {
            $_SESSION["mensaje"] = "Ya tienes una reserva para este producto.";
            $_SESSION["tipo"] = "warning";

            header("Location: index.php?controller=producto&action=detalle&id=" . $id_producto);
            exit;
        }

        $reservasActuales = Reserva::contarReservasPorProducto($id_producto);

        if ($reservasActuales >= $producto["limite_reservas"]) {
            $_SESSION["mensaje"] = "Ya no quedan reservas disponibles para este producto.";
            $_SESSION["tipo"] = "warning";

            header("Location: index.php?controller=producto&action=detalle&id=" . $id_producto);
            exit;
        }

        if (!Reserva::crear($id_usuario, $id_producto)) {
            $_SESSION["mensaje"] = "Ya has reservado anteriormente este producto y no puedes volver a reservarlo.";
            $_SESSION["tipo"] = "warning";

            header("Location: index.php?controller=producto&action=detalle&id=" . $id_producto);
            exit;
        }

        $_SESSION["mensaje"] = "Reserva realizada correctamente.";
        $_SESSION["tipo"] = "success";

        header("Location: index.php?controller=reserva&action=misReservas");
        exit;
    }
    

    public function misReservas(){
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];

        $reservas = Reserva::obtenerPorUsuario($id_usuario);

        require_once __DIR__ . "/../views/reservas/mis_reservas.php";
    }
    public function cancelar(){
    if (!isset($_SESSION["usuario"])) {
        header("Location: index.php?controller=usuario&action=login");
        exit;
    }

    if (!isset($_GET["id"])) {
        header("Location: index.php?controller=reserva&action=misReservas");
        exit;
    }

    $id_usuario = $_SESSION["usuario"]["id_usuario"];
    $id_reserva = $_GET["id"];

    Reserva::cancelar($id_reserva, $id_usuario);

    header("Location: index.php?controller=reserva&action=misReservas");
    exit;
    }
    public function cambiarEstadoAdmin(){
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "admin") {
            header("Location: index.php?controller=home&action=index");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_reserva = $_POST["id_reserva"];
            $nuevo_estado = $_POST["estado"];

            Reserva::cambiarEstado($id_reserva, $nuevo_estado);

            header("Location: index.php?controller=admin&action=reservas");
            exit;
        }
    }
}

?>