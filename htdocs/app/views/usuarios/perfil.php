<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

    if (!isset($_SESSION["usuario"])) {
    header("Location: index.php?controller=usuario&action=login");
    exit;

    }

$usuario = $_SESSION["usuario"];
?>

<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-5">

    <h1 class="mb-4">Mi perfil</h1>
        <?php if (!empty($reservas_pendientes_pago)): ?>

            <div class="alert alert-warning">

                <h5> Reserva pendiente de pago</h5>

                <?php foreach ($reservas_pendientes_pago as $reserva): ?>

                    <p class="mb-2">
                        Tu reserva de
                        <strong><?= $reserva["nombre"] ?></strong>
                        ha sido confirmada.

                        Debes completar el pago antes del:

                        <strong>
                            <?= date("d/m/Y H:i", strtotime($reserva["fecha_limite_pago"])) ?>
                        </strong>
                    </p>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    <div id="mensaje"></div>

    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Datos personales
                </div>

                <div class="card-body">
                    <form id="formPerfil">

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input 
                                type="text" 
                                name="nombre" 
                                class="form-control"
                                value="<?= htmlspecialchars($usuario['nombre']) ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input 
                                type="text" 
                                name="apellidos" 
                                class="form-control"
                                value="<?= htmlspecialchars($usuario['apellidos']) ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control"
                                value="<?= htmlspecialchars($usuario['email']) ?>"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-dark">
                            Guardar cambios
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Cambiar contraseña
                </div>

                <div class="card-body">
                    <form id="formPassword">

                        <div class="mb-3">
                            <label class="form-label">Contraseña actual</label>
                            <input 
                                type="password" 
                                name="actual" 
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input 
                                type="password" 
                                name="nueva" 
                                class="form-control"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-outline-dark">
                            Cambiar contraseña
                        </button>

                    </form>
                </div>
            </div>
        </div>

    </div>

   <div class="row mt-4">

    <div class="col-md-3 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title">Reservas</h5>

                <p class="card-text">
                    Consulta tus productos reservados.
                </p>

                <a 
                    href="index.php?controller=reserva&action=misReservas" 
                    class="btn btn-outline-dark mt-auto"
                >
                    Mis reservas
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title">Pedidos</h5>

                <p class="card-text">
                    Revisa tus compras realizadas.
                </p>

                <a 
                    href="index.php?controller=pedido&action=misPedidos" 
                    class="btn btn-outline-dark mt-auto"
                >
                    Mis pedidos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title">Direcciones</h5>

                <p class="card-text">
                    Gestiona tus direcciones de envío.
                </p>

                <a 
                    href="index.php?controller=direccion&action=index" 
                    class="btn btn-outline-dark mt-auto"
                >
                    Mis direcciones
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 d-flex">
        <div class="card h-100 w-100 shadow-sm">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title">Sesión</h5>

                <p class="card-text">
                    Salir de tu cuenta.
                </p>

                <a 
                    href="index.php?controller=usuario&action=logout" 
                    class="btn btn-outline-danger mt-auto"
                >
                    Cerrar sesión
                </a>
            </div>
        </div>
    </div>

</div>

<script>
const mensaje = document.getElementById("mensaje");

function mostrarMensaje(texto, tipo) {
    mensaje.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${texto}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
}

document.getElementById("formPerfil").addEventListener("submit", function(e) {
    e.preventDefault();

    const datos = new FormData(this);

    fetch("index.php?controller=usuario&action=actualizarPerfil", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            mostrarMensaje("Perfil actualizado correctamente", "success");
        } else {
            mostrarMensaje(data.mensaje || "Error al actualizar el perfil", "danger");
        }
    })
    .catch(error => {
        mostrarMensaje("Error en la petición", "danger");
    });
});

document.getElementById("formPassword").addEventListener("submit", function(e) {
    e.preventDefault();

    const datos = new FormData(this);

    fetch("index.php?controller=usuario&action=cambiarPassword", {
        method: "POST",
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            mostrarMensaje("Contraseña cambiada correctamente", "success");
            document.getElementById("formPassword").reset();
        } else {
            mostrarMensaje(data.mensaje || "Error al cambiar la contraseña", "danger");
        }
    })
    .catch(error => {
        mostrarMensaje("Error en la petición", "danger");
    });
});
</script>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>