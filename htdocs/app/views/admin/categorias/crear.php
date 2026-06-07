<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<div class="container mt-4">

    <h1>Añadir categoría</h1>

    <a 
        href="index.php?controller=adminCategoria&action=index"
        class="btn btn-outline-dark mb-3"
    >
        ← Volver
    </a>

    <form 
        action="index.php?controller=adminCategoria&action=guardar"
        method="POST"
    >

        <div class="mb-3">
            <label class="form-label">Nombre de la categoría</label>

            <input 
                type="text"
                name="nombre"
                class="form-control"
                required
            >
        </div>

        <button
            type="submit"
           class="btn btn-dark"
        >
            Guardar categoría
        </button>
        

    </form>

</div>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>