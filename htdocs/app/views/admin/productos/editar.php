<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<?php
if (!isset($producto)) {
    header("Location: index.php?controller=adminProducto&action=index");
    exit;
}

$categorias = $categorias ?? [];
$piedras = $piedras ?? [];
$imagenes = $imagenes ?? [];
?>

<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Editar producto</h1>

        <a href="index.php?controller=adminProducto&action=index" class="btn btn-outline-dark">
            ← Volver
        </a>
    </div>

    <form 
        action="index.php?controller=adminProducto&action=actualizar" 
        method="POST" 
        enctype="multipart/form-data"
    >
        <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                Información del producto
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                           value="<?= htmlspecialchars($producto['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($producto['descripcion']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control"
                               value="<?= $producto['precio']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control"
                               value="<?= $producto['stock']; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="id_categoria" class="form-control" required>
                            <option value="">Selecciona una categoría</option>

                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria["id_categoria"] ?>"
                                    <?= $producto["id_categoria"] == $categoria["id_categoria"] ? "selected" : ""; ?>>
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
                                <option value="<?= $piedra["id_piedra"] ?>"
                                    <?= $producto["id_piedra"] == $piedra["id_piedra"] ? "selected" : ""; ?>>
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
                        <?= $producto['exclusivo'] == 1 ? 'checked' : ''; ?>
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
                        value="<?= $producto['limite_reservas']; ?>"
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

                <?php if (!empty($producto["imagen"])): ?>
                    <img 
                        src="/Joyeria/public/<?= htmlspecialchars($producto['imagen']); ?>" 
                        class="img-fluid rounded shadow-sm mb-3"
                        style="max-height: 260px; object-fit: cover;"
                        alt="<?= htmlspecialchars($producto["nombre"]); ?>"
                    >
                <?php else: ?>
                    <p class="text-muted">Este producto no tiene imagen principal.</p>
                <?php endif; ?>

                <input type="file" name="imagen" class="form-control" accept="image/*">

                <small class="text-muted d-block mt-2">
                    Si no subes una nueva imagen, se mantiene la actual.
                </small>

            </div>
        </div>

        

        <button type="submit" class="btn btn-dark  mb-5">
            Guardar cambios
        </button>

    </form>

</div>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>