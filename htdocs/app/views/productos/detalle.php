<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($producto) || empty($producto)) {
    header("Location: index.php?controller=producto&action=index");
    exit;
}

$imagenes = $imagenes ?? [];
$reservasDisponibles = $reservasDisponibles ?? null;

$rutaImagenPrincipal = !empty($producto["imagen"])
    ? rtrim(Config::$base_url, '/') . '/' . ltrim($producto["imagen"], '/')
    : null;
?>

<div class="container mt-5 mb-5">

    <a href="index.php?controller=producto&action=index" class="btn btn-outline-dark mb-4">
        ← Volver a productos
    </a>

    <div class="row g-4 align-items-start">

        <div class="col-md-5">

            <?php if ($rutaImagenPrincipal): ?>
                <img 
                    src="<?= htmlspecialchars($rutaImagenPrincipal) ?>" 
                    class="img-fluid rounded shadow-sm mb-3"
                    alt="<?= htmlspecialchars($producto["nombre"]) ?>"
                    style="width: 100%; max-height: 520px; object-fit: cover;"
                >
            <?php else: ?>
                <div class="alert alert-secondary">
                    Este producto no tiene imagen principal.
                </div>
            <?php endif; ?>

            <?php if (!empty($imagenes)): ?>
                <div class="row g-2">
                    <?php foreach ($imagenes as $imagen): ?>
                        <?php
                            $rutaImagenAdicional = rtrim(Config::$base_url, '/') . '/' . ltrim($imagen["imagen"], '/');
                        ?>

                        <div class="col-4">
                            <img 
                                src="<?= htmlspecialchars($rutaImagenAdicional) ?>"
                                class="img-fluid rounded shadow-sm border"
                                style="height: 120px; width: 100%; object-fit: cover;"
                                alt="Imagen adicional"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <div class="col-md-7">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="mb-2">
                                <?= htmlspecialchars($producto["nombre"]) ?>
                            </h1>

                            <?php if ($producto["exclusivo"] == 1): ?>
                                <span class="badge bg-dark">Producto exclusivo</span>
                            <?php else: ?>
                                <span class="badge bg-success">Compra directa</span>
                            <?php endif; ?>
                        </div>

                        <p class="fs-3 fw-bold mb-0">
                            <?= number_format($producto["precio"], 2) ?> €
                        </p>
                    </div>

                    <hr>

                    <p class="text-muted">
                        <?= nl2br(htmlspecialchars($producto["descripcion"])) ?>
                    </p>

                    <div class="row mt-4">

                        <?php if (!empty($producto["piedra"])): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="mb-1">Piedra</h6>
                                        <p class="mb-0">
                                            <?= htmlspecialchars($producto["piedra"]) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($producto["categoria"])): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="mb-1">Categoría</h6>
                                        <p class="mb-0">
                                            <?= htmlspecialchars($producto["categoria"]) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php if ($producto["exclusivo"] == 1): ?>

                        <div class="alert alert-info mt-3">
                            <strong>Reservas disponibles:</strong>
                            <?= $reservasDisponibles ?> / <?= $producto["limite_reservas"] ?>
                        </div>

                        <?php if ($reservasDisponibles > 0): ?>
                            <a 
                                href="index.php?controller=reserva&action=crear&id_producto=<?= $producto["id_producto"] ?>" 
                                class="btn btn-dark w-100 mt-2"
                            >
                                Reservar producto
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary w-100 mt-2" disabled>
                                Producto completo
                            </button>
                        <?php endif; ?>

                    <?php else: ?>

                        <?php if ($producto["stock"] > 0): ?>
                            <div class="alert alert-success mt-3">
                                <strong>Stock disponible:</strong>
                                <?= $producto["stock"] ?>
                            </div>

                            <a 
                                href="index.php?controller=carrito&action=agregar&id=<?= $producto["id_producto"] ?>" 
                                class="btn btn-dark w-100 mt-2"
                            >
                                Añadir al carrito
                            </a>
                        <?php else: ?>
                            <div class="alert alert-danger mt-3">
                                Este producto está actualmente sin stock.
                            </div>

                            <button class="btn btn-secondary w-100 mt-2" disabled>
                                Sin stock
                            </button>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>