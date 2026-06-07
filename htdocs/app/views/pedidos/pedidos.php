<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <h1 class="mb-4">Mis pedidos</h1>

    <?php if (empty($pedidos)): ?>

        <div class="alert alert-info">
            Todavía no tienes pedidos realizados.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nº Pedido</th>
                        <th>Fecha</th>
                        <th>Dirección</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Detalle</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?= $pedido["id_pedido"] ?></td>

                            <td>
                                <?= date("d/m/Y H:i", strtotime($pedido["fecha_pedido"])) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($pedido["direccion"]) ?>,
                                <?= htmlspecialchars($pedido["ciudad"]) ?>
                                <?= htmlspecialchars($pedido["codigo_postal"]) ?>
                            </td>

                            <td>
                                <?= number_format($pedido["total"], 2) ?> €
                            </td>

                            <td>
                                <?php if ($pedido["estado"] == "pendiente"): ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php elseif ($pedido["estado"] == "pagado"): ?>
                                    <span class="badge bg-success">Pagado</span>
                                <?php elseif ($pedido["estado"] == "enviado"): ?>
                                    <span class="badge bg-primary">Enviado</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Cancelado</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a 
                                    href="index.php?controller=pedido&action=detalle&id=<?= $pedido["id_pedido"] ?>" 
                                    class="btn btn-sm btn-outline-dark"
                                >
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    <?php endif; ?>
    

</div>
    <a href="index.php?controller=usuario&action=perfil" class="btn btn-secondary mt-3 mb-5">
    Volver a mi perfil
    </a>
<?php require_once __DIR__ . "/../layouts/footer.php"; ?>