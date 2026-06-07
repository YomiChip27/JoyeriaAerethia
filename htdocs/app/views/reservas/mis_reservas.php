<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <h1 class="mb-4">Mis reservas</h1>

    <?php if (empty($reservas)): ?>

        <div class="alert alert-info">
            Todavía no tienes reservas.
        </div>

    <?php else: ?>

        <div class="row">

            <?php foreach ($reservas as $reserva): ?>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">

                        <img 
                            src="<?= $reserva['imagen']; ?>" 
                            class="card-img-top" 
                            alt="<?= $reserva['nombre']; ?>"
                        >

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                <?= $reserva['nombre']; ?>
                            </h5>

                            <p>
                                <strong>Precio:</strong>
                                <?= $reserva['precio']; ?> €
                            </p>

                            <p>
                                <strong>Fecha reserva:</strong>
                                <?= date("d/m/Y H:i", strtotime($reserva['fecha_reserva'])); ?>
                            </p>

                            <p>
                                <strong>Estado:</strong>

                                <?php if ($reserva["estado"] == "activa"): ?>
                                    <span class="badge bg-primary">Activa</span>

                                <?php elseif ($reserva["estado"] == "pendiente_pago"): ?>
                                    <span class="badge bg-warning text-dark">Pendiente de pago</span>

                                <?php elseif ($reserva["estado"] == "completada"): ?>
                                    <span class="badge bg-success">Completada</span>

                                <?php elseif ($reserva["estado"] == "cancelada"): ?>
                                    <span class="badge bg-danger">Cancelada</span>

                                <?php else: ?>
                                    <span class="badge bg-secondary">Sin estado</span>
                                <?php endif; ?>
                            </p>

                            <?php if ($reserva["estado"] == "pendiente_pago"): ?>

                                <div class="alert alert-warning py-2">
                                    <strong>Pago pendiente</strong><br>

                                    <?php if (!empty($reserva["fecha_limite_pago"])): ?>
                                        Debes pagar antes del
                                        <strong>
                                            <?= date("d/m/Y H:i", strtotime($reserva["fecha_limite_pago"])); ?>
                                        </strong>
                                    <?php else: ?>
                                        Fecha límite no disponible.
                                    <?php endif; ?>
                                </div>

                                <a 
                                    href="index.php?controller=pago&action=pagarReserva&id_reserva=<?= $reserva["id_reserva"] ?>"
                                    class="btn btn-dark btn-sm mt-auto"
                                >
                                    Pagar reserva
                                </a>

                            <?php endif; ?>

                            <?php if ($reserva["estado"] == "activa"): ?>
                                <a 
                                    href="index.php?controller=reserva&action=cancelar&id=<?= $reserva['id_reserva']; ?>" 
                                    class="btn btn-danger mt-auto"
                                    onclick="return confirm('¿Seguro que quieres cancelar esta reserva?');"
                                >
                                    Cancelar reserva
                                </a>
                                
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <a href="index.php?controller=usuario&action=perfil" class="btn btn-secondary mt-3 mb-5">
        Volver a mi perfil
    </a>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>