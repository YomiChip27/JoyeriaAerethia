<?php

require_once __DIR__ . "/../models/Reserva.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Producto.php";
require_once __DIR__ . "/../models/Pedido.php";

class AdminController {

    private function comprobarAdmin() {
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "admin") {
            header("Location: index.php?controller=home&action=index");
            exit;
        }
    }

    public function index() {
        $this->comprobarAdmin();

        $totalUsuarios = Usuario::contar();
        $totalProductos = Producto::contar();
        $totalReservas = Reserva::contar();
        $totalPedidos = Pedido::contar();

        require_once __DIR__ . "/../views/admin/dashboard.php";
    }

    public function reservas() {
        $this->comprobarAdmin();

        $reservas = Reserva::obtenerTodas();

        require_once __DIR__ . "/../views/admin/reservas.php";
    }

    public function usuarios() {
        $this->comprobarAdmin();

        $buscar = $_GET["buscar"] ?? null;

        $limite = 5;

        $pagina = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

        if ($pagina < 1) {
            $pagina = 1;
        }

        $inicio = ($pagina - 1) * $limite;

        $totalUsuarios = Usuario::contarTodosFiltrados($buscar);

        $totalPaginas = ceil($totalUsuarios / $limite);

        $usuarios = Usuario::obtenerTodos($buscar, $inicio, $limite);

        require_once __DIR__ . "/../views/admin/usuarios.php";
    }

    public function pedidos() {
        $this->comprobarAdmin();

        $buscar = $_GET["buscar"] ?? null;
        $limite = 5;
        $pagina = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
        if ($pagina < 1) {
            $pagina = 1;
        }
        $inicio = ($pagina - 1) * $limite;
        $totalPedidos = Pedido::contarTodosFiltrados($buscar);
        $totalPaginas = ceil($totalPedidos / $limite);
        $pedidos = Pedido::obtenerTodos($buscar, $inicio, $limite);

        require_once __DIR__ . "/../views/admin/pedidos.php";
    }

    public function editarUsuario() {
        $this->comprobarAdmin();

        $id_usuario = $_GET["id"] ?? null;

        if (!$id_usuario) {
            header("Location: index.php?controller=admin&action=usuarios");
            exit;
        }

        $usuario = Usuario::obtenerPorId($id_usuario);

        if (!$usuario) {
            header("Location: index.php?controller=admin&action=usuarios");
            exit;
        }

        require_once __DIR__ . "/../views/admin/editarUsuario.php";
    }

    public function actualizarUsuario() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_usuario = $_POST["id_usuario"];
            $nombre = trim($_POST["nombre"]);
            $apellidos = trim($_POST["apellidos"]);
            $email = trim($_POST["email"]);
            $rol = $_POST["rol"];

            Usuario::actualizarDesdeAdmin($id_usuario, $nombre, $apellidos, $email, $rol);

            $_SESSION["mensaje"] = "Usuario actualizado correctamente.";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=admin&action=usuarios");
            exit;
        }
    }

    public function eliminarUsuario() {
        $this->comprobarAdmin();

        $id_usuario = $_GET["id"] ?? null;

        if ($id_usuario && $id_usuario != $_SESSION["usuario"]["id_usuario"]) {
            Usuario::eliminar($id_usuario);

            $_SESSION["mensaje"] = "Usuario desactivado correctamente.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=admin&action=usuarios");
        exit;
    }

    public function reactivarUsuario() {
        $this->comprobarAdmin();

        $id_usuario = $_GET["id"] ?? null;

        if ($id_usuario) {
            Usuario::reactivar($id_usuario);

            $_SESSION["mensaje"] = "Usuario reactivado correctamente.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=admin&action=usuarios");
        exit;
    }

    public function detallePedido() {
        $this->comprobarAdmin();

        $id_pedido = $_GET["id"] ?? null;

        if (!$id_pedido) {
            header("Location: index.php?controller=admin&action=pedidos");
            exit;
        }

        $pedido = Pedido::obtenerPedidoAdmin($id_pedido);
        $detalles = Pedido::obtenerDetalleAdmin($id_pedido);

        if (!$pedido) {
            header("Location: index.php?controller=admin&action=pedidos");
            exit;
        }

        require_once __DIR__ . "/../views/admin/detallePedido.php";
    }

    public function cambiarEstadoPedido() {
        $this->comprobarAdmin();

        $id_pedido = $_GET["id"] ?? null;
        $estado = $_GET["estado"] ?? null;

        if ($id_pedido && $estado) {
            Pedido::actualizarEstado($id_pedido, $estado);

            $_SESSION["mensaje"] = "Estado del pedido actualizado.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=admin&action=pedidos");
        exit;
    }

    public function cambiarEstadoReserva() {
        $this->comprobarAdmin();

        $id_reserva = $_GET["id"] ?? null;
        $estado = $_GET["estado"] ?? null;

        if ($id_reserva && $estado) {
            Reserva::cambiarEstado($id_reserva, $estado);

            $_SESSION["mensaje"] = "Estado de la reserva actualizado.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=admin&action=reservas");
        exit;
    }
    public function paginacionProducto() {
        $this->comprobarAdmin();

        $buscar = $_GET["buscar"] ?? null;

        $limite = 1;

        $pagina = isset($_GET["pagina"]) ? (int)$_GET["pagina"] : 1;

        if ($pagina < 1) {
            $pagina = 5;
        }

        $inicio = ($pagina - 1) * $limite;

        $totalProductos = Producto::contarTodosFiltrados(null, null, $buscar);

        $totalPaginas = ceil($totalProductos / $limite);

        $productos = Producto::obtenerTodos(null, null, $buscar, $inicio, $limite);

        require_once __DIR__ . "/../views/admin/productos/index.php";
    }
}

?>