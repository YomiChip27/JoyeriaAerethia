<?php
   
require_once __DIR__ . "/../models/Producto.php";
require_once __DIR__ . "/../models/Reserva.php";
require_once __DIR__ . "/../models/Categorias.php";
require_once __DIR__ . "/../models/Piedra.php";
require_once __DIR__ . "/../models/ImagenProducto.php";

    class ProductoController{
       public function index() {
            $id_categoria = $_GET["id_categoria"] ?? null;
            $id_piedra = $_GET["id_piedra"] ?? null;
            $buscar = $_GET["buscar"] ?? null;

            $productosPorPagina = 6;
            $paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

            if ($paginaActual < 1) {
                $paginaActual = 1;
            }

            $inicio = ($paginaActual - 1) * $productosPorPagina;

            $totalProductos = Producto::contarTodosFiltrados($id_categoria, $id_piedra, $buscar);
            $totalPaginas = ceil($totalProductos / $productosPorPagina);

            $productos = Producto::obtenerTodos(
                $id_categoria,
                $id_piedra,
                $buscar,
                $inicio,
                $productosPorPagina
            );

            $categorias = Categoria::obtenerTodas();
            $piedras = Piedra::obtenerTodas();

            require_once __DIR__ . "/../views/productos/index.php";
        }
                
        public function detalle() {

            if (!isset($_GET["id"])) {
                header("Location: index.php?controller=producto&action=index");
                exit;
            }

            $id_producto = $_GET["id"];

            $producto = Producto::obtenerPorId($id_producto);
            $imagenes = ImagenProducto::obtenerPorProducto($id_producto);

            $reservasActivas = 0;
            $reservasDisponibles = null;

            if ($producto && $producto["exclusivo"] == 1) {

                $reservasActivas = Reserva::contarReservasPorProducto(
                    $producto["id_producto"]
                );

                $reservasDisponibles =
                    $producto["limite_reservas"] - $reservasActivas;
            }

            require_once __DIR__ . "/../views/productos/detalle.php";
        }

    }

?>