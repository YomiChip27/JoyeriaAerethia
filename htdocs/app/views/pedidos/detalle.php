<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <h1 class="mb-4">Detalle del pedido</h1>

    <a href="index.php?controller=pedido&action=misPedidos" class="btn btn-secondary mb-3">
        Volver a mis pedidos
    </a>

    <?php if (empty($detalles)): ?>

        <div class="alert alert-warning">
            No se han encontrado detalles para este pedido.
        </div>

    <?php else: ?>

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                    <tr>
                        <td><?= htmlspecialchars($detalle["nombre"]) ?></td>
                        <td><?= $detalle["cantidad"] ?></td>
                        <td><?= number_format($detalle["precio_unitario"], 2) ?> €</td>
                        <td><?= number_format($detalle["subtotal"], 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>