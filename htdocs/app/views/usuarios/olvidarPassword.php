<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5" style="max-width: 500px;">

    <h1 class="mb-4">Restablecer contraseña</h1>

    <?php if (isset($_SESSION["mensaje"])): ?>
        <div class="alert alert-info">
            <?= $_SESSION["mensaje"] ?>
        </div>
        <?php unset($_SESSION["mensaje"]); ?>
    <?php endif; ?>

    <form action="index.php?controller=usuario&action=enviarResetPassword" method="POST">

        <div class="mb-3">
            <label class="form-label">Introduce tu email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark">
            Enviar enlace
        </button>

        <a href="index.php?controller=usuario&action=login" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>