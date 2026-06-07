<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<?php
if (!isset($direcciones)) {
    $direcciones = [];
}
?>
<h1 class="mb-4">Confirmar pedido</h1>

<a href="index.php?controller=carrito&action=index" class="btn btn-outline-dark mb-3">
    ← Volver al carrito
</a>

<form action="index.php?controller=carrito&action=finalizar" method="POST">

    <h4 class="mb-3">Selecciona una dirección de envío</h4>

    <div class="row">
        <?php foreach ($direcciones as $direccion): ?>
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">

                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="id_direccion" 
                                value="<?= $direccion["id_direccion"] ?>"
                                id="direccion<?= $direccion["id_direccion"] ?>"
                                <?= $direccion["principal"] == 1 ? "checked" : "" ?>
                                required
                            >

                            <label 
                                class="form-check-label" 
                                for="direccion<?= $direccion["id_direccion"] ?>"
                            >
                                <strong><?= htmlspecialchars($direccion["nombre_destinatario"]) ?></strong>
                            </label>
                        </div>

                        <hr>

                        <p class="mb-1">
                            <?= htmlspecialchars($direccion["direccion"]) ?>
                        </p>

                        <p class="mb-1">
                            <?= htmlspecialchars($direccion["ciudad"]) ?>,
                            <?= htmlspecialchars($direccion["provincia"]) ?>
                            <?= htmlspecialchars($direccion["codigo_postal"]) ?>
                        </p>

                        <p class="mb-1">
                            <?= htmlspecialchars($direccion["pais"]) ?>
                        </p>

                        <p class="mb-0">
                            Tel: <?= htmlspecialchars($direccion["telefono"]) ?>
                        </p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h4 class="mt-4 mb-3">Resumen del pedido</h4>

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($_SESSION["carrito"] as $item): ?>
                <?php $subtotal = $item["precio"] * $item["cantidad"]; ?>

                <tr>
                    <td><?= htmlspecialchars($item["nombre"]) ?></td>
                    <td><?= $item["cantidad"] ?></td>
                    <td><?= number_format($item["precio"], 2) ?> €</td>
                    <td><?= number_format($subtotal, 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th><?= number_format($total, 2) ?> €</th>
            </tr>
        </tfoot>
    </table>

    <button type="submit" class="btn btn-outline-dark mb-5">
        Finalizar pedido
    </button>

</form>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>