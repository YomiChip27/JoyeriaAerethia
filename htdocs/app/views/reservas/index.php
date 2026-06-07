<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($productos)) {
    $productos = [];
}   

if (empty($productos)) {
    echo "<p>No hay productos exclusivos disponibles en este momento.</p>";
    require_once __DIR__ . "/../layouts/footer.php";
    exit;
}
?>

<h1 class="mb-4">Productos Exclusivos</h1>

<div class="row">

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

                <div class="card-body text-center">

                    <h5>
                        <?= htmlspecialchars($producto["nombre"]) ?>
                    </h5>

                    <p>
                        <?= number_format($producto["precio"], 2) ?> €
                    </p>

                    <div class="d-flex justify-content-center gap-2">
                        <a
                            href="index.php?controller=producto&action=detalle&id=<?= $producto["id_producto"] ?>"
                            class="btn btn-outline-secondary"
                        >
                            Ver producto
                        </a>

                        <?php if ($producto["exclusivo"] == 1): ?>
                            <a
                                href="index.php?controller=reserva&action=crear&id_producto=<?= $producto["id_producto"] ?>"
                                class="btn btn-dark"
                            >
                                Reservar
                            </a>
                        <?php else: ?>
                            <a
                                href="index.php?controller=carrito&action=agregar&id=<?= $producto["id_producto"] ?>"
                                class="btn btn-dark"
                            >
                                Añadir
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>