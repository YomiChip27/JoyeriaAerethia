<?php
require_once __DIR__ . "/../models/Pedido.php";
require_once __DIR__ . "/../models/Reserva.php";

class PedidoController {

    public function misPedidos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];

        $pedidos = Pedido::obtenerPorUsuario($id_usuario);

        require_once __DIR__ . "/../views/pedidos/pedidos.php";
    }

    public function detalle(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        if (!isset($_GET["id"])) {
            header("Location: index.php?controller=pedido&action=misPedidos");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];
        $id_pedido = $_GET["id"];

        $pedidos = Pedido::obtenerPorUsuario($id_usuario);
        $pedido = null;

        foreach ($pedidos as $p) {
            if ($p["id_pedido"] == $id_pedido) {
                $pedido = $p;
                break;
            }
        }

        if (!$pedido) {
            header("Location: index.php?controller=pedido&action=misPedidos");
            exit;
        }

        $detalles = Pedido::obtenerDetalle($id_pedido, $id_usuario);

        require_once __DIR__ . "/../views/pedidos/detalle.php";
    }
}
?>