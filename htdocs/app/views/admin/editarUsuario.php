<?php require_once __DIR__ . "/../layouts/header.php"; ?>
    <?php
    if (!isset($usuario)) {
        header("Location: index.php?controller=admin&action=usuarios");
        exit;
    }
?>

<h1 class="mb-4">Editar usuario</h1>

<a href="index.php?controller=admin&action=usuarios" class="btn btn-outline-dark mb-3">
    ← Volver a usuarios
</a>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="index.php?controller=admin&action=actualizarUsuario" method="POST">

            <input type="hidden" name="id_usuario" value="<?= $usuario["id_usuario"] ?>">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    class="form-control"
                    value="<?= htmlspecialchars($usuario["nombre"]) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input 
                    type="text" 
                    name="apellidos" 
                    class="form-control"
                    value="<?= htmlspecialchars($usuario["apellidos"]) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control"
                    value="<?= htmlspecialchars($usuario["email"]) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-select" required>
                    <option value="user" <?= $usuario["rol"] == "user" ? "selected" : "" ?>>
                        Usuario
                    </option>

                    <option value="admin" <?= $usuario["rol"] == "admin" ? "selected" : "" ?>>
                        Administrador
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-dark">
                Guardar cambios
            </button>

        </form>

    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>