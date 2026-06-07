<?php

require_once __DIR__ . "/../models/Producto.php";
require_once __DIR__ . "/../models/Pedido.php";
require_once __DIR__ . "/../models/Direccion.php";
require_once __DIR__ . "/../models/Reserva.php";

    class CarritoController {

        public function index() {
            if (!isset($_SESSION["carrito"])) {
                $_SESSION["carrito"] = [];
            }

            require_once __DIR__ . "/../views/carrito/index.php";
        }

        public function agregar() {
            if (!isset($_GET["id"])) {
                header("Location: index.php?controller=producto&action=index");
                exit;
            }

            $id_producto = $_GET["id"];
            $producto = Producto::obtenerPorId($id_producto);

            if (!$producto) {
                header("Location: index.php?controller=producto&action=index");
                exit;
            }

            if ($producto["exclusivo"] == 1) {
                header("Location: index.php?controller=producto&action=detalle&id=" . $id_producto);
                exit;
            }

            if (!isset($_SESSION["carrito"])) {
                $_SESSION["carrito"] = [];
            }

            if (isset($_SESSION["carrito"][$id_producto])) {

                if ($_SESSION["carrito"][$id_producto]["cantidad"] < $producto["stock"]) {

                    $_SESSION["carrito"][$id_producto]["cantidad"]++;

                    $_SESSION["mensaje"] = "Producto añadido al carrito.";
                    $_SESSION["tipo"] = "success";

                } else {

                    $_SESSION["mensaje"] = "No hay más stock disponible.";
                    $_SESSION["tipo"] = "warning";
                }

            } else {

                $_SESSION["carrito"][$id_producto] = [
                    "id_producto" => $producto["id_producto"],
                    "nombre" => $producto["nombre"],
                    "precio" => $producto["precio"],
                    "imagen" => $producto["imagen"],
                    "cantidad" => 1
                ];
            }

            $_SESSION["mensaje"] = "Producto añadido al carrito.";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }

        public function eliminar() {
            if (isset($_GET["id"]) && isset($_SESSION["carrito"][$_GET["id"]])) {
                unset($_SESSION["carrito"][$_GET["id"]]);

                $_SESSION["mensaje"] = "Producto eliminado del carrito.";
                $_SESSION["tipo"] = "info";
            }

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }

        public function vaciar() {
            unset($_SESSION["carrito"]);

            $_SESSION["mensaje"] = "Carrito vaciado.";
            $_SESSION["tipo"] = "info";

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }
        public function sumar() {

            if (isset($_GET["id"]) && isset($_SESSION["carrito"][$_GET["id"]])) {

                if (isset($_SESSION["carrito"][$_GET["id"]]["es_reserva"])) {

                    $_SESSION["mensaje"] = "No puedes aumentar la cantidad de un producto reservado.";
                    $_SESSION["tipo"] = "warning";

                    header("Location: index.php?controller=carrito&action=index");
                    exit;
                }

                $producto = Producto::obtenerPorId($_GET["id"]);

                if ($_SESSION["carrito"][$_GET["id"]]["cantidad"] < $producto["stock"]) {

                    $_SESSION["carrito"][$_GET["id"]]["cantidad"]++;

                } else {

                    $_SESSION["mensaje"] = "No hay más stock disponible.";
                    $_SESSION["tipo"] = "warning";
                }
            }

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }

       public function restar() {

            if (isset($_GET["id"]) && isset($_SESSION["carrito"][$_GET["id"]])) {

                if (isset($_SESSION["carrito"][$_GET["id"]]["es_reserva"])) {

                    $_SESSION["mensaje"] = "No puedes modificar la cantidad de un producto reservado.";
                    $_SESSION["tipo"] = "warning";

                    header("Location: index.php?controller=carrito&action=index");
                    exit;
                }

                if ($_SESSION["carrito"][$_GET["id"]]["cantidad"] > 1) {
                    $_SESSION["carrito"][$_GET["id"]]["cantidad"]--;
                } else {
                    unset($_SESSION["carrito"][$_GET["id"]]);
                }

                $_SESSION["mensaje"] = "Cantidad actualizada.";
                $_SESSION["tipo"] = "info";
            }

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }
        public function confirmar() {

            if (!isset($_SESSION["usuario"])) {
                $_SESSION["mensaje"] = "Debes iniciar sesión para confirmar el pedido.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=usuario&action=login");
                exit;
            }

            if (empty($_SESSION["carrito"])) {
                $_SESSION["mensaje"] = "El carrito está vacío.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=carrito&action=index");
                exit;
            }

            $id_usuario = $_SESSION["usuario"]["id_usuario"];

            $direcciones = Direccion::obtenerPorUsuario($id_usuario);

            if (empty($direcciones)) {
                $_SESSION["mensaje"] = "Debes añadir una dirección antes de realizar el pedido.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=direccion&action=crear");
                exit;
            }

            $total = 0;

            foreach ($_SESSION["carrito"] as $item) {
                $total += $item["precio"] * $item["cantidad"];
            }

            require_once __DIR__ . "/../views/carrito/confirmar.php";
        }

        public function finalizar() {

            if (!isset($_SESSION["usuario"])) {
                $_SESSION["mensaje"] = "Debes iniciar sesión para finalizar el pedido.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=usuario&action=login");
                exit;
            }

            if (empty($_SESSION["carrito"])) {
                $_SESSION["mensaje"] = "El carrito está vacío.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=carrito&action=index");
                exit;
            }

            if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST["id_direccion"])) {
                $_SESSION["mensaje"] = "Debes seleccionar una dirección.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=carrito&action=confirmar");
                exit;
            }

            $id_usuario = $_SESSION["usuario"]["id_usuario"];
            $id_direccion = $_POST["id_direccion"];

            $total = 0;

            foreach ($_SESSION["carrito"] as $item) {
                $total += $item["precio"] * $item["cantidad"];
            }

            $id_pedido = Pedido::crearPedido(
                $id_usuario,
                $id_direccion,
                $total,
                $_SESSION["carrito"]
            );

            if ($id_pedido) {

                unset($_SESSION["carrito"]);

                header("Location: index.php?controller=pago&action=pagarPedido&id_pedido=" . $id_pedido);
                exit;
            }

            $_SESSION["mensaje"] = "Error al realizar el pedido.";
            $_SESSION["tipo"] = "danger";

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }

        public function agregarReserva() {

            if (!isset($_SESSION["usuario"])) {

                $_SESSION["mensaje"] = "Debes iniciar sesión.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=usuario&action=login");
                exit;
            }

            if (!isset($_GET["id_reserva"])) {

                header("Location: index.php?controller=reserva&action=misReservas");
                exit;
            }

            $id_reserva = $_GET["id_reserva"];

            $reserva = Reserva::obtenerReservaPorId($id_reserva);

            if (!$reserva) {

                $_SESSION["mensaje"] = "Reserva no encontrada.";
                $_SESSION["tipo"] = "danger";

                header("Location: index.php?controller=reserva&action=misReservas");
                exit;
            }

            if ($reserva["estado"] != "pendiente_pago") {

                $_SESSION["mensaje"] = "Esta reserva no puede pagarse.";
                $_SESSION["tipo"] = "warning";

                header("Location: index.php?controller=reserva&action=misReservas");
                exit;
            }

            if (!isset($_SESSION["carrito"])) {
                $_SESSION["carrito"] = [];
            }

            $producto = Producto::obtenerPorId($reserva["id_producto"]);

            $_SESSION["carrito"][$producto["id_producto"]] = [
                "id_producto" => $producto["id_producto"],
                "nombre" => $producto["nombre"],
                "precio" => $producto["precio"],
                "imagen" => $producto["imagen"],
                "cantidad" => 1,
                "id_reserva"=>$id_reserva,
                "es_reserva" => true
            ];

            $_SESSION["mensaje"] = "Producto añadido al carrito para completar el pago.";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=carrito&action=index");
            exit;
        }
    }


    
?>