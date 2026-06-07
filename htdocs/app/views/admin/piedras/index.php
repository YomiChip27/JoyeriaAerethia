<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<?php
if (!isset($piedras)) {
    $piedras = [];
}
?>

<h1>Gestión de piedras</h1>

<a 
    href="index.php?controller=adminPiedra&action=crear" 
    class="btn btn-dark mb-3"
>
    Añadir piedra
</a>

<a 
    href="index.php?controller=admin&action=index" 
    class="btn btn-outline-dark mb-3"
>
    Volver al panel
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
        <?php foreach ($piedras as $piedra): ?>
            <tr>
                <td><?= $piedra["id_piedra"] ?></td>

                <td><?= htmlspecialchars($piedra["nombre"]) ?></td>

                <td>
                    <a 
                        href="index.php?controller=adminPiedra&action=eliminar&id=<?= $piedra["id_piedra"] ?>" 
                        class="btn btn-sm btn-dark"
                        onclick="return confirm('¿Seguro que quieres eliminar esta piedra?')"
                    >
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>