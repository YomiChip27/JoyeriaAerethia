<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1>Registro de usuario</h1>

<form action="index.php?controller=usuario&action=guardar" method="POST">

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input 
            type="text" 
            name="nombre" 
            class="form-control" 
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Apellidos</label>
        <input 
            type="text" 
            name="apellidos" 
            class="form-control" 
            required
        >
    </div>

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
        Registrarme
    </button>

</form>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>