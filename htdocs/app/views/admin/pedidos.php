<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<?php
$pedidos = $pedidos ?? [];
$buscar = $buscar ?? "";
$pagina = $pagina ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>
<h1 class="mb-4">Pedidos realizados</h1>

<div class="d-flex justify-content-between align-items-center mb-3">

    <a href="index.php?controller=admin&action=index" class="btn btn-outline-dark">
        ← Volver al panel
    </a>

    <form method="GET" class="d-flex gap-2">
        <input type="hidden" name="controller" value="admin">
        <input type="hidden" name="action" value="pedidos">

        <input
            type="text"
            name="buscar"
            class="form-control"
            placeholder="Buscar pedido..."
            value="<?= htmlspecialchars($buscar ?? '') ?>"
        >

        <button type="submit" class="btn btn-dark">
            Buscar
        </button>

        <?php if (!empty($buscar)): ?>
            <a href="index.php?controller=admin&action=pedidos" class="btn btn-outline-dark">
                Limpiar
            </a>
        <?php endif; ?>
    </form>

</div>

<?php if (empty($pedidos)): ?>

    <div class="alert alert-info">
        No hay pedidos registrados.
    </div>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID pedido</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Detalle</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td>#<?= $pedido["id_pedido"] ?></td>

                        <td>
                            <?= htmlspecialchars($pedido["nombre"]) ?>
                            <?= htmlspecialchars($pedido["apellidos"]) ?>
                        </td>

                        <td><?= htmlspecialchars($pedido["email"]) ?></td>

                        <td>
                            <?= date("d/m/Y H:i", strtotime($pedido["fecha_pedido"])) ?>
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
                                href="index.php?controller=admin&action=detallePedido&id=<?= $pedido["id_pedido"] ?>" 
                                class="btn btn-sm btn-outline-dark"
                            >
                                Ver detalle
                            </a>
                        </td>
                        <td>

                           

                        <div class="dropdown d-inline">

                            <button
                                class="btn btn-sm btn-dark dropdown-toggle"
                                data-bs-toggle="dropdown"
                            >
                                Estado
                            </button>

                            <ul class="dropdown-menu">

                                <li>
                                    <a class="dropdown-item"
                                    href="index.php?controller=admin&action=cambiarEstadoPedido&id=<?= $pedido["id_pedido"] ?>&estado=pendiente">
                                        Pendiente
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item"
                                    href="index.php?controller=admin&action=cambiarEstadoPedido&id=<?= $pedido["id_pedido"] ?>&estado=pagado">
                                        Pagado
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item"
                                    href="index.php?controller=admin&action=cambiarEstadoPedido&id=<?= $pedido["id_pedido"] ?>&estado=enviado">
                                        Enviado
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger"
                                    href="index.php?controller=admin&action=cambiarEstadoPedido&id=<?= $pedido["id_pedido"] ?>&estado=cancelado">
                                        Cancelado
                                    </a>
                                </li>

                            </ul>

                        </div>

            </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <?php if ($totalPaginas > 1): ?>

    <nav class="mt-4">
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
        
        <ul class="pagination justify-content-center">

            <?php if ($pagina > 1): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="index.php?controller=admin&action=pedidos&pagina=<?= $pagina - 1 ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        Anterior
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                    <a
                        class="page-link"
                        href="index.php?controller=admin&action=pedidos&pagina=<?= $i ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="index.php?controller=admin&action=pedidos&pagina=<?= $pagina + 1 ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        Siguiente
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

<?php endif; ?>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>