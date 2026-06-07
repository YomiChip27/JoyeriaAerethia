<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mis direcciones</h1>

        <a href="index.php?controller=direccion&action=crear" class="btn btn-dark">
            Añadir dirección
        </a>
    </div>

    <?php if (empty($direcciones)): ?>

        <div class="alert alert-info">
            Todavía no tienes direcciones guardadas.
        </div>

    <?php else: ?>

        <div class="row">
            <?php foreach ($direcciones as $direccion): ?>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">

                        <div class="card-header bg-dark text-white d-flex justify-content-between">
                            <span>
                                <?= htmlspecialchars($direccion["nombre_destinatario"]) ?>
                            </span>

                            <?php if ($direccion["principal"] == 1): ?>
                                <span class="badge bg-success">Principal</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <p class="mb-1">
                                <strong>Dirección:</strong>
                                <?= htmlspecialchars($direccion["direccion"]) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Ciudad:</strong>
                                <?= htmlspecialchars($direccion["ciudad"]) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Provincia:</strong>
                                <?= htmlspecialchars($direccion["provincia"]) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Código postal:</strong>
                                <?= htmlspecialchars($direccion["codigo_postal"]) ?>
                            </p>

                            <p class="mb-1">
                                <strong>País:</strong>
                                <?= htmlspecialchars($direccion["pais"]) ?>
                            </p>

                            <p class="mb-1">
                                <strong>Teléfono:</strong>
                                <?= htmlspecialchars($direccion["telefono"] ?? "") ?>
                            </p>
                        </div>
                        <?php if ($direccion["principal"] == 0): ?>
                            <a 
                                href="index.php?controller=direccion&action=principal&id=<?= $direccion["id_direccion"] ?>" 
                                class="btn btn-sm btn-outline-dark"
                            >
                                Marcar como principal
                            </a>
                        <?php endif; ?>

                        <div class="card-footer">
                            <a 
                                href="index.php?controller=direccion&action=editar&id=<?= $direccion["id_direccion"] ?>" 
                                class="btn btn-sm btn-dark"
                            >
                                Editar
                            </a>

                            <a 
                                href="index.php?controller=direccion&action=eliminar&id=<?= $direccion["id_direccion"] ?>" 
                                class="btn btn-sm btn-outline-dark"
                                onclick="return confirm('¿Seguro que quieres eliminar esta dirección?')"
                            >
                                Eliminar
                            </a>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <a href="index.php?controller=usuario&action=perfil" class="btn btn-secondary mt-3 mb-3">
        Volver a mi perfil
    </a>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>