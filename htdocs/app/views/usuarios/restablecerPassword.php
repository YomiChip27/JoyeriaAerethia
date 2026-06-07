<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5" style="max-width: 500px;">

    <h1 class="mb-4">Nueva contraseña</h1>

    <?php if (isset($_SESSION["error"])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION["error"] ?>
        </div>
        <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>

    <form action="index.php?controller=usuario&action=guardarNuevaPassword" method="POST">

        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET["token"]) ?>">

        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Repetir contraseña</label>
            <input type="password" name="password2" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark">
            Guardar nueva contraseña
        </button>

    </form>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>