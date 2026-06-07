<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($novedades)) {
    $novedades = [];
}

if (!isset($categorias)) {
    $categorias = [];
}

if (!isset($piedras)) {
    $piedras = [];
}
?>
<style>
    .hero-banner{
        min-height: 500px;

        background-image: url('/img/banner.png');
        background-size: cover;
        background-position: center;
        color:white;
        position: relative;
    }
    .hero-banner h1{
    color: #ffffff;
    font-weight: 700;
    text-shadow: 0 3px 10px rgba(0,0,0,0.7);
    }

    .hero-banner p{
        color: #ffffff;
        text-shadow: 0 2px 8px rgba(0,0,0,0.7);
    }
    .hero-banner::before{
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.15);
        pointer-events: none;

    }

    .hero-banner .container{
        position: relative;
        z-index: 2;
    }
    
</style>
<section class="hero-banner text-white d-flex align-items-center justify-content-center mb-5">
    <div class="hero-content text-center">
        <h1 class="display-4 fw-bold mb-3">
            Bienvenido a la Joyería Online
        </h1>

        <p class="lead mb-4">
            Joyas artesanales, piezas exclusivas y diseños únicos hechos con mimo.
        </p>

        <a href="index.php?controller=producto&action=index" class="btn btn-light me-2 px-4">
            Ver productos
        </a>

        <a href="index.php?controller=sobreNosotros&action=index" class="btn btn-outline-light px-4">
            Sobre nosotros
        </a>
    </div>
</section>

<div class="row">

    <aside class="col-md-3 mb-4">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                Categorías
            </div>

            <div class="list-group list-group-flush">

                <a 
                    href="index.php?controller=producto&action=index"
                    class="list-group-item list-group-item-action"
                >
                    Todas
                </a>

                <?php foreach ($categorias as $categoria): ?>
                    <a 
                        href="index.php?controller=producto&action=index&id_categoria=<?= $categoria["id_categoria"] ?>"
                        class="list-group-item list-group-item-action"
                    >
                        <?= htmlspecialchars($categoria["nombre"]) ?>
                    </a>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                Piedras
            </div>

            <div class="list-group list-group-flush">

                <a 
                    href="index.php?controller=producto&action=index"
                    class="list-group-item list-group-item-action"
                >
                    Todas
                </a>

                <?php foreach ($piedras as $piedra): ?>
                    <a 
                        href="index.php?controller=producto&action=index&id_piedra=<?= $piedra["id_piedra"] ?>"
                        class="list-group-item list-group-item-action"
                    >
                        <?= htmlspecialchars($piedra["nombre"]) ?>
                    </a>
                <?php endforeach; ?>

            </div>
        </div>

    </aside>

    <section class="col-md-9">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Novedades</h2>

        </div>

        <div class="row">

            <?php if (empty($novedades)): ?>

                <div class="col-12">
                    <div class="alert alert-info">
                        Todavía no hay novedades disponibles.
                    </div>
                </div>

            <?php endif; ?>

            <?php foreach ($novedades as $producto): ?>

                <div class="col-md-4 mb-4 d-flex">

                    <div class="card h-100 w-100 shadow-sm">

                    <?php if (!empty($producto["imagen"])): ?>
                       <img
                            src="<?= rtrim(Config::$base_url, '/') . '/' . ltrim($producto["imagen"], '/') ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($producto["nombre"]) ?>"
                            style="height:250px; object-fit:cover;"
                        >
                    <?php endif; ?>

                        <div class="card-body d-flex flex-column text-center">

                            <h5 class="card-title mb-2" style="min-height: 48px;">
                                <?= htmlspecialchars($producto["nombre"]) ?>
                            </h5>

                            <?php if ($producto["exclusivo"] == 1): ?>
                                <span class="badge bg-dark mb-2 align-self-center">
                                    Exclusivo
                                </span>
                            <?php endif; ?>

                            <p class="fw-bold mb-3">
                                <?= number_format($producto["precio"], 2) ?> €
                            </p>

                            <div class="d-flex gap-2 mt-auto justify-content-center">

                                <a 
                                    href="index.php?controller=producto&action=detalle&id=<?= $producto["id_producto"] ?>"
                                    class="btn btn-outline-secondary"
                                >
                                    Ver
                                </a>

                                <?php if ($producto["exclusivo"] == 1): ?>

                                    <a 
                                        href="index.php?controller=reserva&action=crear&id_producto=<?= $producto["id_producto"] ?>"
                                        class="btn btn-dark"
                                    >
                                        Reservar
                                    </a>

                                <?php else: ?>

                                    <?php if ($producto["stock"] > 0): ?>

                                        <a 
                                            href="index.php?controller=carrito&action=agregar&id=<?= $producto["id_producto"] ?>"
                                            class="btn btn-dark"
                                        >
                                            Añadir
                                        </a>

                                    <?php else: ?>

                                        <button
                                            class="btn btn-secondary"
                                            disabled
                                        >
                                            Sin stock
                                        </button>

                                    <?php endif; ?>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>