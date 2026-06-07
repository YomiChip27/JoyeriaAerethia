<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<?php
if (!isset($reservas)) {
    $reservas = [];
}
?>

<h1>Gestión de reservas</h1>

<a 
    href="index.php?controller=admin&action=index" 
    class="btn btn-outline-dark mb-3"
>
    ← Volver al panel admin
</a>

<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Fecha reserva</th>
            <th>Estado</th>
            <th>Fecha límite de pago</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?= $reserva["id_reserva"]; ?></td>

                <td><?= $reserva["nombre_producto"]; ?></td>

                <td>
                    <img
                        src="/<?= $reserva["imagen"] ?>"
                        width="70"
                        alt=""
                    >
                </td>

                <td>
                    <?= $reserva["nombre_usuario"]; ?>
                    <?= $reserva["apellidos"]; ?>
                </td>

                <td><?= $reserva["email"]; ?></td>

                <td>
                    <?= date("d/m/Y H:i", strtotime($reserva["fecha_reserva"])); ?>
                </td>

                <td>
                    <?php if ($reserva["estado"] == "activa"): ?>
                        <span class="badge bg-primary">Activa</span>

                    <?php elseif ($reserva["estado"] == "pendiente_pago"): ?>
                        <span class="badge bg-warning text-dark">Pendiente de pago</span>

                    <?php elseif ($reserva["estado"] == "completada"): ?>
                        <span class="badge bg-success">Completada</span>

                    <?php elseif ($reserva["estado"] == "cancelada"): ?>
                        <span class="badge bg-danger">Cancelada</span>

                    <?php else: ?>
                        <span class="badge bg-secondary">
                            Sin estado
                        </span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($reserva["estado"] == "pendiente_pago" && !empty($reserva["fecha_limite_pago"])): ?>
                        <span class="badge bg-warning text-dark">
                            <?= date("d/m/Y H:i", strtotime($reserva["fecha_limite_pago"])); ?>
                        </span>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($reserva["estado"] == "activa"): ?>
                        <a 
                            href="index.php?controller=admin&action=cambiarEstadoReserva&id=<?= $reserva['id_reserva']; ?>&estado=pendiente_pago"
                            class="btn btn-outline-dark btn-sm mb-1"
                        >
                            Aceptar pago
                        </a>
                    <?php endif; ?>

                    <?php if ($reserva["estado"] == "pendiente_pago"): ?>
                        <a 
                            href="index.php?controller=admin&action=cambiarEstadoReserva&id=<?= $reserva['id_reserva']; ?>&estado=completada"
                            class="btn btn-outline-dark btn-sm mb-1"
                        >
                            Completar
                        </a>
                    <?php endif; ?>

                    <?php if ($reserva["estado"] != "cancelada" && $reserva["estado"] != "completada"): ?>
                        <a 
                            href="index.php?controller=admin&action=cambiarEstadoReserva&id=<?= $reserva['id_reserva']; ?>&estado=cancelada"
                            class="btn btn-dark btn-sm mb-1"
                        >
                            Cancelar
                        </a>
                    <?php endif; ?>

                    <?php if ($reserva["estado"] == "cancelada"): ?>
                        <a 
                            href="index.php?controller=admin&action=cambiarEstadoReserva&id=<?= $reserva['id_reserva']; ?>&estado=activa"
                            class="btn btn-dark btn-sm mb-1"
                        >
                            Reactivar
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>