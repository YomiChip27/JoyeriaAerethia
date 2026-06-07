<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<?php
$categorias = $categorias ?? [];
$piedras = $piedras ?? [];
?>

<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Crear producto</h1>

        <a href="index.php?controller=adminProducto&action=index" class="btn btn-outline-dark">
            ← Volver
        </a>
    </div>

    <form 
        action="index.php?controller=adminProducto&action=guardar" 
        method="POST" 
        enctype="multipart/form-data"
    >

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                Información del producto
            </div>

            <div class="card-body">

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
                    <label class="form-label">Descripción</label>
                    <textarea 
                        name="descripcion" 
                        class="form-control"
                        rows="4"
                        required
                    ></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio</label>
                        <input 
                            type="number" 
                            step="0.01"
                            name="precio" 
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input 
                            type="number" 
                            name="stock" 
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría</label>

                        <select name="id_categoria" class="form-control" required>
                            <option value="">Selecciona una categoría</option>

                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria["id_categoria"] ?>">
                                    <?= htmlspecialchars($categoria["nombre"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Piedra</label>

                        <select name="id_piedra" class="form-control" required>
                            <option value="">Selecciona una piedra</option>

                            <?php foreach ($piedras as $piedra): ?>
                                <option value="<?= $piedra["id_piedra"] ?>">
                                    <?= htmlspecialchars($piedra["nombre"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                Reservas
            </div>

            <div class="card-body">

                <div class="form-check mb-3">
                    <input 
                        type="checkbox" 
                        name="exclusivo" 
                        value="1"
                        class="form-check-input"
                        id="exclusivo"
                    >

                    <label class="form-check-label" for="exclusivo">
                        Producto exclusivo
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Límite de reservas</label>
                    <input 
                        type="number" 
                        name="limite_reservas" 
                        class="form-control"
                        value="0"
                    >
                </div>

                <small class="text-muted">
                    Usa este apartado solo para productos exclusivos que se puedan reservar.
                </small>

            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                Imagen principal
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Subir imagen</label>

                    <input 
                        type="file" 
                        name="imagen" 
                        class="form-control"
                        accept="image/*"
                        required
                    >
                </div>

                <small class="text-muted">
                    La imagen se guardará como imagen principal del producto.
                </small>

            </div>
        </div>

        <button type="submit" class="btn btn-success w-100 mb-5">
            Guardar producto
        </button>

    </form>

</div>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>