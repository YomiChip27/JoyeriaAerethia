<?php
require_once __DIR__ . "/../models/Producto.php";
require_once __DIR__ . "/../models/Categorias.php";
require_once __DIR__ . "/../models/Piedra.php";
class HomeController
{
    public function index(){
        $novedades = Producto::obtenerNovedades(6);
        $categorias = Categoria::obtenerTodas();
        $piedras = Piedra::obtenerTodas();

        require_once __DIR__ . "/../views/home/index.php";
    }
}
?>