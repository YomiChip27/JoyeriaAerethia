<?php
$controllerActual = $_GET["controller"] ?? "home";
$actionActual = $_GET["action"] ?? "index";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joyería Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/joyeria/public/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    $totalCarrito = 0;

    if (!empty($_SESSION["carrito"])) {
        foreach ($_SESSION["carrito"] as $item) {
            $totalCarrito += $item["cantidad"];
        }
    }
    ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="/img/LogoHeader.png" alt="Logo" height="120">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a 
                        class="nav-link <?= $controllerActual == 'home' ? 'active fw-bold' : '' ?>" 
                        href="index.php"
                    >
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a 
                        class="nav-link <?= $controllerActual == 'producto' ? 'active fw-bold' : '' ?>" 
                        href="index.php?controller=producto&action=index"
                    >
                        Productos
                    </a>
                </li>

                

                <li class="nav-item">
                    <a 
                        class="nav-link <?= $controllerActual == 'reserva' ? 'active fw-bold' : '' ?>" 
                        href="index.php?controller=reserva&action=index"
                    >
                        Reservas
                    </a>
                </li>

                <?php if (isset($_SESSION["usuario"])): ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Hola, <?= htmlspecialchars($_SESSION["usuario"]["nombre"]); ?>
                        </span>
                    </li>

                    <?php if ($_SESSION["usuario"]["rol"] == "admin"): ?>

                        <li class="nav-item">
                            <a 
                                class="nav-link <?= $controllerActual == 'admin' || str_starts_with($controllerActual, 'admin') ? 'active fw-bold text-warning' : 'text-warning' ?>" 
                                href="index.php?controller=admin&action=index"
                            >
                                Panel Admin
                            </a>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $controllerActual == 'usuario' && $actionActual == 'perfil' ? 'active fw-bold' : '' ?>" 
                            href="index.php?controller=usuario&action=perfil"
                        >
                            Mi perfil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            href="index.php?controller=usuario&action=logout"
                        >
                            Cerrar sesión
                        </a>
                    </li>
                        <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=carrito&action=index">
                        🛒 Carrito

                        <?php if ($totalCarrito > 0): ?>
                            <span class="badge bg-danger">
                                <?= $totalCarrito ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php else: ?>
                    

                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $controllerActual == 'usuario' && $actionActual == 'login' ? 'active fw-bold' : '' ?>" 
                            href="index.php?controller=usuario&action=login"
                        >
                            Iniciar sesión
                        </a>
                    </li>

                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $controllerActual == 'usuario' && $actionActual == 'registro' ? 'active fw-bold' : '' ?>" 
                            href="index.php?controller=usuario&action=registro"
                        >
                            Registrarse
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

            <form
                action="index.php"
                method="GET"
                class="d-flex ms-lg-3 mt-3 mt-lg-0"
            >
                <input type="hidden" name="controller" value="producto">
                <input type="hidden" name="action" value="index">

                <input
                    type="text"
                    name="buscar"
                    class="form-control me-2"
                    placeholder="Buscar producto..."
                    value="<?= isset($_GET["buscar"]) ? htmlspecialchars($_GET["buscar"]) : "" ?>"
                >

                
            </form>

        </div>

    </div>
</nav>

<main class="container mt-4 flex-grow-1">

<?php if (isset($_SESSION["mensaje"])): ?>

    <?php $tipo = $_SESSION["tipo"] ?? "info"; ?>

    <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION["mensaje"]; ?>

        <button 
            type="button" 
            class="btn-close" 
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>
    </div>

    <?php
        unset($_SESSION["mensaje"]);
        unset($_SESSION["tipo"]);
    ?>

<?php endif; ?>