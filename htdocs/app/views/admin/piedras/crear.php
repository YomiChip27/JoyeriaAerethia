<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<h1>Añadir piedra</h1>

<a 
    href="index.php?controller=adminPiedra&action=index" 
    class="btn btn-outline-dark mb-3"
>
    ← Volver
</a>

<form action="index.php?controller=adminPiedra&action=guardar" method="POST">

    <div class="mb-3">
        <label class="form-label">Nombre de la piedra</label>

        <input 
            type="text" 
            name="nombre" 
            class="form-control"
            required
        >
    </div>

    <button type="submit" class="btn btn-dark">
        Guardar piedra
    </button>

</form>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>