<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
$usuarios = $usuarios ?? [];
$buscar = $buscar ?? "";
$pagina = $pagina ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>

<div class="container mt-4 mb-5">

    <h1 class="mb-4">Usuarios registrados</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="index.php?controller=admin&action=index" class="btn btn-outline-dark">
            ← Volver al panel
        </a>

        <form method="GET" class="d-flex gap-2">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="usuarios">

            <input 
                type="text" 
                name="buscar" 
                class="form-control" 
                placeholder="Buscar usuario..."
                value="<?= htmlspecialchars($buscar) ?>"
            >

            <button type="submit" class="btn btn-dark">
                Buscar
            </button>

            <?php if (!empty($buscar)): ?>
                <a href="index.php?controller=admin&action=usuarios" class="btn btn-outline-dark">
                    Limpiar
                </a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (empty($usuarios)): ?>

        <div class="alert alert-info">
            No se han encontrado usuarios.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha de registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario["id_usuario"] ?></td>
                            <td><?= htmlspecialchars($usuario["nombre"]) ?></td>
                            <td><?= htmlspecialchars($usuario["apellidos"]) ?></td>
                            <td><?= htmlspecialchars($usuario["email"]) ?></td>

                            <td>
                                <?php if ($usuario["rol"] == "admin"): ?>
                                    <span class="badge bg-warning text-dark">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Usuario</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($usuario["activo"] == 1): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= date("d/m/Y H:i", strtotime($usuario["fecha_registro"])) ?>
                            </td>

                            <td>
                                <a 
                                    href="index.php?controller=admin&action=editarUsuario&id=<?= $usuario["id_usuario"] ?>" 
                                    class="btn btn-sm btn-outline-dark"
                                >
                                    Editar
                                </a>

                                <?php if ($usuario["id_usuario"] != $_SESSION["usuario"]["id_usuario"]): ?>

                                    <?php if ($usuario["activo"] == 1): ?>
                                        <a
                                            href="index.php?controller=admin&action=eliminarUsuario&id=<?= $usuario["id_usuario"] ?>"
                                            class="btn btn-sm btn-dark"
                                            onclick="return confirm('¿Seguro que quieres desactivar este usuario?')"
                                        >
                                            Desactivar
                                        </a>
                                    <?php else: ?>
                                        <a
                                            href="index.php?controller=admin&action=reactivarUsuario&id=<?= $usuario["id_usuario"] ?>"
                                            class="btn btn-sm btn-dark"
                                        >
                                            Reactivar
                                        </a>
                                    <?php endif; ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

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
                        href="index.php?controller=admin&action=usuarios&pagina=<?= $pagina - 1 ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        Anterior
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                    <a 
                        class="page-link"
                        href="index.php?controller=admin&action=usuarios&pagina=<?= $i ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
                <li class="page-item">
                    <a 
                        class="page-link"
                        href="index.php?controller=admin&action=usuarios&pagina=<?= $pagina + 1 ?>&buscar=<?= urlencode($buscar) ?>"
                    >
                        Siguiente
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>