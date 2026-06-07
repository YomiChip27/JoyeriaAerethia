<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../config/stripe.php";
require_once __DIR__ . "/../models/Pedido.php";
require_once __DIR__ . "/../models/Reserva.php";

class PagoController {

    public function pagarPedido() {
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_pedido = $_GET["id_pedido"] ?? null;

        if (!$id_pedido) {
            header("Location: index.php?controller=pedido&action=misPedidos");
            exit;
        }

        $pedido = Pedido::obtenerPedidoAdmin($id_pedido);

        if (!$pedido || $pedido["estado"] !== "pendiente") {
            header("Location: index.php?controller=pedido&action=misPedidos");
            exit;
        }

        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

        $session = \Stripe\Checkout\Session::create([
            "payment_method_types" => ["card"],
            "mode" => "payment",
            "line_items" => [[
                "price_data" => [
                    "currency" => "eur",
                    "product_data" => [
                        "name" => "Pedido #" . $pedido["id_pedido"],
                    ],
                    "unit_amount" => intval($pedido["total"] * 100),
                ],
                "quantity" => 1,
            ]],
            "success_url" => "http://localhost/Joyeria/public/index.php?controller=pago&action=exitoPedido&id_pedido=" . $id_pedido,
            "cancel_url" => "http://localhost/Joyeria/public/index.php?controller=pedido&action=misPedidos",
        ]);

        header("Location: " . $session->url);
        exit;
    }

    public function exitoPedido() {
        $id_pedido = $_GET["id_pedido"] ?? null;

        if ($id_pedido) {
            Pedido::actualizarEstado($id_pedido, "pagado");
        }

        $_SESSION["mensaje"] = "Pedido pagado correctamente.";
        $_SESSION["tipo"] = "success";

        header("Location: index.php?controller=pedido&action=misPedidos");
        exit;
    }

    public function pagarReserva() {
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_reserva = $_GET["id_reserva"] ?? null;

        if (!$id_reserva) {
            header("Location: index.php?controller=usuario&action=perfil");
            exit;
        }

        $reserva = Reserva::obtenerPorId($id_reserva);

        if (!$reserva || $reserva["estado"] !== "pendiente_pago") {
            header("Location: index.php?controller=usuario&action=perfil");
            exit;
        }

        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

        $session = \Stripe\Checkout\Session::create([
            "payment_method_types" => ["card"],
            "mode" => "payment",
            "line_items" => [[
                "price_data" => [
                    "currency" => "eur",
                    "product_data" => [
                        "name" => "Reserva: " . $reserva["nombre"],
                    ],
                    "unit_amount" => intval($reserva["precio"] * 100),
                ],
                "quantity" => 1,
            ]],
            "success_url" => "http://localhost/Joyeria/public/index.php?controller=pago&action=exitoReserva&id_reserva=" . $id_reserva,
            "cancel_url" => "http://localhost/Joyeria/public/index.php?controller=usuario&action=perfil",
        ]);

        header("Location: " . $session->url);
        exit;
    }

    public function exitoReserva() {
        $id_reserva = $_GET["id_reserva"] ?? null;

        if ($id_reserva) {
            Reserva::cambiarEstado($id_reserva, "completada");
        }

        $_SESSION["mensaje"] = "Reserva pagada correctamente.";
        $_SESSION["tipo"] = "success";

        header("Location: index.php?controller=usuario&action=perfil");
        exit;
    }
}