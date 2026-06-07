<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($pedido)) {
    header("Location: index.php?controller=admin&action=pedidos");
    exit;
}
?>

<h1 class="mb-4">Detalle del pedido #<?= $pedido["id_pedido"] ?></h1>

<a href="index.php?controller=admin&action=pedidos" class="btn btn-outline-dark mb-3">
    ← Volver a pedidos
</a>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title">Datos del pedido</h5>

        <p><strong>Cliente:</strong> 
            <?= htmlspecialchars($pedido["nombre"]) ?> 
            <?= htmlspecialchars($pedido["apellidos"]) ?>
        </p>

        <p><strong>Email:</strong> <?= htmlspecialchars($pedido["email"]) ?></p>

        <p><strong>Fecha:</strong> 
            <?= date("d/m/Y H:i", strtotime($pedido["fecha_pedido"])) ?>
        </p>

        <p><strong>Estado:</strong> 
            <?php if ($pedido["estado"] == "pendiente"): ?>
                <span class="badge bg-warning text-dark">Pendiente</span>
            <?php elseif ($pedido["estado"] == "pagado"): ?>
                <span class="badge bg-success">Pagado</span>
            <?php elseif ($pedido["estado"] == "enviado"): ?>
                <span class="badge bg-primary">Enviado</span>
            <?php else: ?>
                <span class="badge bg-danger">Cancelado</span>
            <?php endif; ?>
        </p>

        <p><strong>Total:</strong> <?= number_format($pedido["total"], 2) ?> €</p>
    </div>
</div>

<h3 class="mb-3">Productos del pedido</h3>

<?php if (empty($detalles)): ?>

    <div class="alert alert-info">
        Este pedido no tiene productos.
    </div>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
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
    </div>

<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>