<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <h1 class="mb-4">Añadir dirección</h1>

    <form action="index.php?controller=direccion&action=guardar" method="POST" class="card shadow-sm p-4">

        <div class="mb-3">
            <label class="form-label">Nombre del destinatario</label>
            <input type="text" name="nombre_destinatario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Provincia</label>
                <input type="text" name="provincia" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Código postal</label>
                <input type="text" name="codigo_postal" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">País</label>
                <input type="text" name="pais" class="form-control" value="España">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="principal" value="1" class="form-check-input" id="principal">
            <label class="form-check-label" for="principal">
                Marcar como dirección principal
            </label>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                Guardar dirección
            </button>

            <a href="index.php?controller=direccion&action=index" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>