<?php

require_once __DIR__ . "/../models/Producto.php";
require_once __DIR__ . "/../models/Categorias.php";
require_once __DIR__ . "/../models/Piedra.php";
require_once __DIR__ . "/../models/ImagenProducto.php";

class AdminProductoController {

    private function comprobarAdmin() {
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "admin") {
            header("Location: index.php");
            exit();
        }
    }

    public function index() {
        $this->comprobarAdmin();

        $buscar = $_GET["buscar"] ?? null;

        $limite = 5;

        $pagina = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

        if ($pagina < 1) {
            $pagina = 1;
        }

        $inicio = ($pagina - 1) * $limite;

        $totalProductos = Producto::contarTodosFiltrados(null, null, $buscar);

        $totalPaginas = ceil($totalProductos / $limite);

        $productos = Producto::obtenerTodos(null, null, $buscar, $inicio, $limite);

        require_once __DIR__ . "/../views/admin/productos/index.php";
    }

    public function crear() {
        $this->comprobarAdmin();
        $categorias = Categoria::obtenerTodas();
        $piedras = Piedra::obtenerTodas();
        require_once __DIR__ . "/../views/admin/productos/crear.php";
    }

    public function guardar() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = trim($_POST["nombre"]);
            $descripcion = trim($_POST["descripcion"]);
            $precio = $_POST["precio"];
            $stock = $_POST["stock"];
            $id_categoria = $_POST["id_categoria"];
            $id_piedra = $_POST["id_piedra"];
            $exclusivo = isset($_POST["exclusivo"]) ? 1 : 0;
            $limite_reservas = $_POST["limite_reservas"];

            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {

                $nombreImagen = time() . "_" . $_FILES["imagen"]["name"];
                $rutaTemporal = $_FILES["imagen"]["tmp_name"];
                $rutaDestino = __DIR__ . "/../../public/img/productos/" . $nombreImagen;

                move_uploaded_file($rutaTemporal, $rutaDestino);

                $imagen = "img/productos/" . $nombreImagen;

            } else {
                $imagen = "";
            }

            Producto::crear(
                $nombre,
                $descripcion,
                $precio,
                $stock,
                $imagen,
                $exclusivo,
                $limite_reservas,
                $id_categoria,
                $id_piedra
            );

            $_SESSION["mensaje"] = "Producto creado correctamente";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=adminProducto&action=index");
            exit;
        }
    }

    public function editar() {
        $this->comprobarAdmin();

        if (!isset($_GET["id"])) {
            header("Location: index.php?controller=adminProducto&action=index");
            exit;
        }

        $id_producto = $_GET["id"];

        $producto = Producto::obtenerPorId($id_producto);

        if (!$producto) {
            header("Location: index.php?controller=adminProducto&action=index");
            exit;
        }
        $categorias = Categoria::obtenerTodas();
        $piedras = Piedra::obtenerTodas();
        $imagenes = ImagenProducto::obtenerPorProducto($id_producto);
        require_once __DIR__ . "/../views/admin/productos/editar.php";
    }

    public function actualizar() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_producto = $_POST["id_producto"];
            $nombre = trim($_POST["nombre"]);
            $descripcion = trim($_POST["descripcion"]);
            $precio = $_POST["precio"];
            $stock = $_POST["stock"];
            $exclusivo = isset($_POST["exclusivo"]) ? 1 : 0;
            $limite_reservas = $_POST["limite_reservas"] ?? 0;
            $id_categoria = $_POST["id_categoria"];
            $id_piedra = $_POST["id_piedra"];

            $productoActual = Producto::obtenerPorId($id_producto);
            $imagen = $productoActual["imagen"];

            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {

                $nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
                $rutaTemporal = $_FILES["imagen"]["tmp_name"];
                $rutaDestino = __DIR__ . "/../../public/img/productos/" . $nombreImagen;

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    $imagen = "img/productos/" . $nombreImagen;
                } else {
                    $_SESSION["mensaje"] = "Error al guardar la imagen principal.";
                    $_SESSION["tipo"] = "danger";

                    header("Location: index.php?controller=adminProducto&action=editar&id=" . $id_producto);
                    exit;
                }
            }

            Producto::actualizar(
                $id_producto,
                $nombre,
                $descripcion,
                $precio,
                $stock,
                $imagen,
                $exclusivo,
                $limite_reservas,
                $id_categoria,
                $id_piedra
            );

            $_SESSION["mensaje"] = "Producto actualizado correctamente";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=adminProducto&action=editar&id=" . $id_producto);
            exit;
        }
    }

    public function eliminar() {
        $this->comprobarAdmin();

        if (!isset($_GET["id"])) {
            header("Location: index.php?controller=adminProducto&action=index");
            exit;
        }

        $id_producto = $_GET["id"];

        Producto::eliminar($id_producto);

        $_SESSION["mensaje"] = "Producto eliminado correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: index.php?controller=adminProducto&action=index");
        exit;
    }
    public function subirImagen() {
        $this->comprobarAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_producto"])) {

            $id_producto = $_POST["id_producto"];

            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {

                $nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
                $rutaTemporal = $_FILES["imagen"]["tmp_name"];
                $rutaDestino = __DIR__ . "/../../public/img/productos/" . $nombreImagen;

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {

                    $imagen = "img/productos/" . $nombreImagen;

                    ImagenProducto::crear($id_producto, $imagen);

                    $_SESSION["mensaje"] = "Imagen añadida correctamente.";
                    $_SESSION["tipo"] = "success";

                } else {
                    $_SESSION["mensaje"] = "Error al mover la imagen a la carpeta img/productos.";
                    $_SESSION["tipo"] = "danger";
                }

            } else {
                $_SESSION["mensaje"] = "No se ha seleccionado ninguna imagen.";
                $_SESSION["tipo"] = "danger";
            }

            header("Location: index.php?controller=adminProducto&action=editar&id=" . $id_producto);
            exit;
        }
    }

    public function eliminarImagen() {
        $this->comprobarAdmin();

        $id_imagen = $_GET["id"] ?? null;
        $id_producto = $_GET["id_producto"] ?? null;

        if ($id_imagen && $id_producto) {
            ImagenProducto::eliminar($id_imagen);

            $_SESSION["mensaje"] = "Imagen eliminada correctamente.";
            $_SESSION["tipo"] = "success";
        }

        header("Location: index.php?controller=adminProducto&action=editar&id=" . $id_producto);
        exit;
    }


}
