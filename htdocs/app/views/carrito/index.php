<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1 class="mb-4">Mi carrito</h1>

<a href="index.php?controller=producto&action=index" class="btn btn-outline-dark mb-3">
    ← Seguir comprando
</a>

<?php if (empty($_SESSION["carrito"])): ?>

    <div class="alert alert-info">
        Tu carrito está vacío.
    </div>

<?php else: ?>

    <?php $total = 0; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($_SESSION["carrito"] as $item): ?>
                    <?php
                        $subtotal = $item["precio"] * $item["cantidad"];
                        $total += $subtotal;
                    ?>

                    <tr>
                        <td>
                            <?= htmlspecialchars($item["nombre"]) ?>
                        </td>

                        <td>
                            <?= number_format($item["precio"], 2) ?> €
                        </td>

                        <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if (!isset($item["es_reserva"])): ?>
                            <a 
                                href="index.php?controller=carrito&action=restar&id=<?= $item["id_producto"] ?>" 
                                class="btn btn-sm btn-outline-dark"
                            >
                                -
                            </a>
                            <?php endif; ?>
                            <span><?= $item["cantidad"] ?></span>

                            <?php if (!isset($item["es_reserva"])): ?>
                            <a href="index.php?controller=carrito&action=sumar&id=<?= $item['id_producto']; ?>" class="btn btn-sm btn-outline-secondary">
                                +
                            </a>
                        <?php endif; ?>
                        </div>
                    </td>

                        <td>
                            <?= number_format($subtotal, 2) ?> €
                        </td>

                        <td>
                            <a 
                                href="index.php?controller=carrito&action=eliminar&id=<?= $item["id_producto"] ?>" 
                                class="btn btn-sm btn-outline-danger"
                            >
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th><?= number_format($total, 2) ?> €</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="index.php?controller=carrito&action=vaciar" class="btn btn-outline-danger">
        Vaciar carrito
    </a>

    <a href="index.php?controller=carrito&action=confirmar" class="btn btn-outline-dark">
    Confirmar pedido
</a>

<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>