
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true
]);

session_start();

require_once __DIR__ . "/app/config/config.php";

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';

$controllerName = ucfirst($controller) . "Controller";


require_once __DIR__ . "/app/controllers/" . $controllerName . ".php";

$controllerObject = new $controllerName();
$controllerObject->$action();
?>