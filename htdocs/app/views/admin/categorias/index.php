<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<?php
if (!isset($categorias)) {
    $categorias = [];
}   
?>

<h1>Gestión de categorías</h1>

<a href="index.php?controller=adminCategoria&action=crear"
   class="btn btn-dark mb-3">
    Añadir categoría
</a>

<a href="index.php?controller=admin&action=index"
   class="btn btn-outline-dark mb-3">
    Volver
</a>

<table class="table table-bordered table-hover">

    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($categorias as $categoria): ?>

            <tr>

                <td><?= $categoria["id_categoria"] ?></td>

                <td><?= htmlspecialchars($categoria["nombre"]) ?></td>

                <td>

                    <a href="index.php?controller=adminCategoria&action=eliminar&id=<?= $categoria["id_categoria"] ?>"
                       class="btn btn-sm btn-dark"
                       onclick="return confirm('¿Eliminar categoría?')">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>