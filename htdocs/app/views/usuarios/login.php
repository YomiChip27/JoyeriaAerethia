<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1>Iniciar sesión</h1>

<form action="index.php?controller=usuario&action=validarLogin" method="POST">

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            class="form-control" 
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input 
            type="password" 
            name="password" 
            class="form-control" 
            required
        >
    </div>

    <button type="submit" class="btn btn-dark">
        Entrar
    </button>
    <a href="index.php?controller=usuario&action=olvidarPassword">
        ¿Has olvidado tu contraseña?
    </a>

</form>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>