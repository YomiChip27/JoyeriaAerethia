<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<?php
if (!isset($categorias)) {
    $categorias = [];
}
if (!isset($piedras)) {
    $piedras = [];
}
if (!isset($productos)) {
    $productos = [];
}
if (!isset($totalPaginas)) {
    $totalPaginas = 0;
}
if (!isset($paginaActual)) {
    $paginaActual = 1;
}

?>

<h1 class="mb-4">Catálogo de productos</h1>

<div class="container">
    <div class="row">

        <aside class="col-md-3 mb-4">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    Categorías
                </div>

                <div class="list-group list-group-flush">

                    <a 
                        href="index.php?controller=producto&action=index"
                        class="list-group-item list-group-item-action"
                    >
                        Todas
                    </a>

                    <?php foreach ($categorias as $categoria): ?>
                        <a 
                            href="index.php?controller=producto&action=index&id_categoria=<?= $categoria["id_categoria"] ?>"
                            class="list-group-item list-group-item-action"
                        >
                            <?= htmlspecialchars($categoria["nombre"]) ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Piedras
                </div>

                <div class="list-group list-group-flush">

                    <a 
                        href="index.php?controller=producto&action=index"
                        class="list-group-item list-group-item-action"
                    >
                        Todas
                    </a>

                    <?php foreach ($piedras as $piedra): ?>
                        <a 
                            href="index.php?controller=producto&action=index&id_piedra=<?= $piedra["id_piedra"] ?>"
                            class="list-group-item list-group-item-action"
                        >
                            <?= htmlspecialchars($piedra["nombre"]) ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>

        </aside>

        <section class="col-md-9">

            <div class="row">

                <?php if (empty($productos)): ?>

                    <div class="col-12">
                        <div class="alert alert-info">
                            No hay productos disponibles para esta selección.
                        </div>
                    </div>

                <?php endif; ?>

                <?php foreach ($productos as $producto): ?>

                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">

                           <?php if (!empty($producto["imagen"])): ?>
                            <img
                                src="<?= rtrim(Config::$base_url, '/') . '/' . ltrim($producto["imagen"], '/') ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($producto["nombre"]) ?>"
                                style="height:250px; object-fit:cover;"
                            >
                        <?php endif; ?>

                            <div class="card-body d-flex flex-column">

                                <h5 class="card-title">
                                    <?= htmlspecialchars($producto['nombre']); ?>
                                </h5>

                                <p class="card-text">
                                    <?= htmlspecialchars($producto['descripcion']); ?>
                                </p>

                                <?php if (!empty($producto["piedra"])): ?>
                                    <p>
                                        <strong>Piedra:</strong>
                                        <?= htmlspecialchars($producto["piedra"]); ?>
                                    </p>
                                <?php endif; ?>

                                <p>
                                    <strong>Precio:</strong> 
                                    <?= number_format($producto['precio'], 2); ?> €
                                </p>

                                <div  class="d-flex gap-2 mt-auto">

                                    <a 
                                        href="index.php?controller=producto&action=detalle&id=<?= $producto['id_producto']; ?>" 
                                        class="btn btn-outline-secondary"
                                    >
                                        Ver
                                    </a>

                                    <?php if ($producto["exclusivo"] == 1): ?>

                                        <a 
                                            href="index.php?controller=reserva&action=crear&id_producto=<?= $producto['id_producto']; ?>"
                                            class="btn btn-dark"
                                        >
                                            Reservar
                                        </a>

                                    <?php else: ?>

                                        <?php if ($producto["stock"] > 0): ?>

                                            <a 
                                                href="index.php?controller=carrito&action=agregar&id=<?= $producto['id_producto']; ?>"
                                                class="btn btn-dark"
                                            >
                                                Añadir
                                            </a>

                                        <?php else: ?>

                                            <button 
                                                class="btn btn-secondary"
                                                disabled
                                            >
                                                Sin stock
                                            </button>

                                        <?php endif; ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        </section>
       <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>

    <style>
        .pagination .page-item.active .page-link{
            background-color: #212529 !important;
            border-color: #212529 !important;
            color: white !important;
        }

        .pagination .page-link{
            color: #212529 !important;
        }

        .pagination .page-link:hover{
            background-color: #212529 !important;
            border-color: #212529 !important;
            color: white !important;
        }
        </style>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php
            $queryBase = "index.php?controller=producto&action=index";

            if (!empty($id_categoria)) {
                $queryBase .= "&id_categoria=" . $id_categoria;
            }

            if (!empty($id_piedra)) {
                $queryBase .= "&id_piedra=" . $id_piedra;
            }

            if (!empty($buscar)) {
                $queryBase .= "&buscar=" . urlencode($buscar);
            }
            ?>

            <?php if ($paginaActual > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $queryBase ?>&pagina=<?= $paginaActual - 1 ?>">
                        Anterior
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $queryBase ?>&pagina=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $queryBase ?>&pagina=<?= $paginaActual + 1 ?>">
                        Siguiente
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

<?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>