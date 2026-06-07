<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($totalUsuarios) || !isset($totalProductos) || !isset($totalReservas) || !isset($totalPedidos)) {
    header("Location: index.php?controller=admin&action=usuarios");
    exit;
}
?>

<h1 class="mb-4">Bienvenido al panel de administración</h1>

<div class="row mb-4">

    <div class="col-md-3 mb-3 d-flex">
        <div class="card text-center shadow-sm h-100 w-100">
            <div class="card-body">
                <h3><?= $totalUsuarios ?></h3>
                <p class="mb-0">Usuarios</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card text-center shadow-sm h-100 w-100">
            <div class="card-body">
                <h3><?= $totalProductos ?></h3>
                <p class="mb-0">Productos</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card text-center shadow-sm h-100 w-100">
            <div class="card-body">
                <h3><?= $totalReservas ?></h3>
                <p class="mb-0">Reservas</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card text-center shadow-sm h-100 w-100">
            <div class="card-body">
                <h3><?= $totalPedidos ?></h3>
                <p class="mb-0">Pedidos</p>
            </div>
        </div>
    </div>

</div>

<a href="index.php" class="btn btn-outline-dark mb-3">
    ← Volver al inicio
</a>

<p>
    Aquí puedes gestionar tu sitio web, revisar estadísticas y administrar usuarios.
</p>

<div class="row mt-4">

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Productos</h5>
                <p class="card-text">Gestiona tus productos, añade nuevos o edita los existentes.</p>
                <a href="index.php?controller=adminProducto&action=index" class="btn btn-outline-dark mt-auto">
                    Gestionar productos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Reservas</h5>
                <p class="card-text">Consulta las reservas realizadas por los usuarios.</p>
                <a href="index.php?controller=admin&action=reservas" class="btn btn-outline-dark mt-auto">
                    Ver reservas
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text">Consulta todos los usuarios registrados.</p>
                <a href="index.php?controller=admin&action=usuarios" class="btn btn-outline-dark mt-auto">
                    Ver usuarios
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Pedidos</h5>
                <p class="card-text">Consulta y actualiza el estado de los pedidos.</p>
                <a href="index.php?controller=admin&action=pedidos" class="btn btn-outline-dark mt-auto">
                    Ver pedidos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Piedras</h5>
                <p class="card-text">Gestiona las piedras disponibles para los productos.</p>
                <a href="index.php?controller=adminPiedra&action=index" class="btn btn-outline-dark mt-auto">
                    Gestionar piedras
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Categorías</h5>
                <p class="card-text">Gestiona las categorías de la tienda.</p>
                <a href="index.php?controller=adminCategoria&action=index" class="btn btn-outline-dark mt-auto">
                    Gestionar categorías
                </a>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>