<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<?php
$productos = $productos ?? [];
$buscar = $buscar ?? "";
$pagina = $pagina ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>

<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Gestión de productos</h1>

        <a href="index.php?controller=admin&action=index" class="btn btn-outline-dark">
            ← Volver al panel admin
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="index.php?controller=adminProducto&action=crear" class="btn btn-dark">
            Crear producto
        </a>

        <form method="GET" class="d-flex gap-2">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="paginacionProducto">

            <input 
                type="text" 
                name="buscar" 
                class="form-control" 
                placeholder="Buscar por nombre, piedra o categoría..."
                value="<?= htmlspecialchars($buscar) ?>"
            >

            <button class="btn btn-dark" type="submit">
                Buscar
            </button>

            <?php if (!empty($buscar)): ?>
                <a href="index.php?controller=admin&action=paginacionProducto" class="btn btn-outline-dark">
                    Limpiar
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Exclusivo</th>
                    <th>Piedra</th>
                    <th>Límite reservas</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $producto["id_producto"]; ?></td>

                            <td>
                                <?php if (!empty($producto["imagen"])): ?>
                                    <img
                                        src="/<?= $producto["imagen"] ?>"
                                        width="70"
                                        alt=""
                                    >
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($producto["nombre"]); ?></td>

                            <td><?= number_format($producto["precio"], 2); ?> €</td>

                            <td><?= $producto["stock"]; ?></td>

                            <td><?= $producto["exclusivo"] == 1 ? "Sí" : "No"; ?></td>

                            <td>
                                <?= !empty($producto["piedra"]) ? htmlspecialchars($producto["piedra"]) : "-"; ?>
                            </td>

                            <td><?= $producto["limite_reservas"]; ?></td>

                            <td>
                                <a 
                                    href="index.php?controller=adminProducto&action=editar&id=<?= $producto['id_producto']; ?>" 
                                    class="btn btn-outline-dark btn-sm"
                                >
                                    Editar
                                </a>

                                <a 
                                    href="index.php?controller=adminProducto&action=eliminar&id=<?= $producto['id_producto']; ?>" 
                                    class="btn btn-dark btn-sm"
                                    onclick="return confirm('¿Seguro que quieres eliminar este producto?');"
                                >
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No se han encontrado productos.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
                    </table>
    </div>
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
        
    <?php if ($totalPaginas > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
               
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a 
                            class="page-link"
                            href="index.php?controller=adminProducto&action=index&pagina=<?= $pagina - 1 ?>&buscar=<?= urlencode($buscar) ?>"
                        >
                            Anterior
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                        <a 
                            class="page-link"
                            href="index.php?controller=adminProducto&action=index&pagina=<?= $i ?>&buscar=<?= urlencode($buscar) ?>"
                        >
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <li class="page-item">
                        <a 
                            class="page-link"
                            href="index.php?controller=adminProducto&action=index&pagina=<?= $pagina + 1 ?>&buscar=<?= urlencode($buscar) ?>"
                        >
                            Siguiente
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>