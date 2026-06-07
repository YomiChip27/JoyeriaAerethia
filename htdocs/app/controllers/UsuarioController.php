<?php

require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Reserva.php";

class UsuarioController
{
    public function registro(){
        require_once __DIR__ . "/../views/usuarios/registro.php";
    }

    public function guardar(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = trim($_POST["nombre"]);
            $apellidos = trim($_POST["apellidos"]);
            $email = trim($_POST["email"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            Usuario::registrar($nombre, $apellidos, $email, $password);

            $_SESSION["mensaje"] = "Usuario registrado correctamente. Ya puedes iniciar sesión.";
            $_SESSION["tipo"] = "success";

            header("Location: index.php?controller=usuario&action=login");
            exit;
        }
    }

    public function login(){
        require_once __DIR__ . "/../views/usuarios/login.php";
    }

    public function validarLogin(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            $usuario = Usuario::obtenerPorEmail($email);
            if ($usuario && $usuario["activo"] == 0) {
                echo "Esta cuenta ha sido desactivada";
                exit;
            }

            if ($usuario && password_verify($password, $usuario["password"])) {

                $_SESSION["usuario"] = $usuario;

                $_SESSION["mensaje"] = "Has iniciado sesión correctamente.";
                $_SESSION["tipo"] = "success";

                header("Location: index.php");
                exit;

            } else {

                $_SESSION["mensaje"] = "Email o contraseña incorrectos.";
                $_SESSION["tipo"] = "danger";

                header("Location: index.php?controller=usuario&action=login");
                exit;
            }
        }
    }

    public function logout(){
        session_destroy();

        session_start();

        $_SESSION["mensaje"] = "Sesión cerrada correctamente.";
        $_SESSION["tipo"] = "info";

        header("Location: index.php");
        exit;
    }

    public function perfil(){

        if (!isset($_SESSION["usuario"])) {
            $_SESSION["mensaje"] = "Debes iniciar sesión para acceder a tu perfil.";
            $_SESSION["tipo"] = "warning";

            header("Location: index.php?controller=usuario&action=login");
            exit;
        }

        $id_usuario = $_SESSION["usuario"]["id_usuario"];

        $reservas_pendientes_pago = Reserva::obtenerPendientesPagoPorUsuario($id_usuario);

        require_once __DIR__ . "/../views/usuarios/perfil.php";
    }

    public function actualizarPerfil(){
        header("Content-Type: application/json");

        if (!isset($_SESSION["usuario"])) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "No autenticado"
            ]);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_SESSION["usuario"]["id_usuario"];
            $nombre = trim($_POST["nombre"] ?? "");
            $apellidos = trim($_POST["apellidos"] ?? "");
            $email = trim($_POST["email"] ?? "");

            if (!$nombre || !$apellidos || !$email) {
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "Campos incompletos"
                ]);
                exit;
            }

            $ok = Usuario::actualizar($id, $nombre, $apellidos, $email);

            if ($ok) {
                $_SESSION["usuario"]["nombre"] = $nombre;
                $_SESSION["usuario"]["apellidos"] = $apellidos;
                $_SESSION["usuario"]["email"] = $email;

                echo json_encode([
                    "ok" => true,
                    "mensaje" => "Perfil actualizado correctamente"
                ]);
            } else {
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "Error al actualizar el perfil"
                ]);
            }
        }
    }

    public function cambiarPassword(){
        header("Content-Type: application/json");

        if (!isset($_SESSION["usuario"])) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "No autenticado"
            ]);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_SESSION["usuario"]["id_usuario"];
            $actual = $_POST["actual"] ?? "";
            $nueva = $_POST["nueva"] ?? "";

            $usuario = Usuario::obtenerPorEmail($_SESSION["usuario"]["email"]);

            if ($usuario && password_verify($actual, $usuario["password"])) {

                $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);

                $ok = Usuario::actualizarPassword($id, $nuevaHash);

                echo json_encode([
                    "ok" => $ok,
                    "mensaje" => $ok ? "Contraseña actualizada correctamente" : "Error al actualizar la contraseña"
                ]);

            } else {
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "Contraseña actual incorrecta"
                ]);
            }
        }
    }
        public function olvidarPassword() {
        require_once __DIR__ . "/../views/usuarios/olvidarPassword.php";
    }

    public function enviarResetPassword() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = $_POST["email"] ?? "";

            $usuario = Usuario::buscarPorEmail($email);

            if ($usuario) {
                $token = bin2hex(random_bytes(32));
                $fecha_expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

                Usuario::guardarTokenReset($email, $token, $fecha_expira);

                $enlace = Config::$base_url . "index.php?controller=usuario&action=restablecerPassword&token=" . $token;

                // En local o para pruebas puedes mostrar el enlace:
                $_SESSION["mensaje"] = "Enlace para restablecer: <a href='$enlace'>$enlace</a>";

                // Más adelante se puede enviar por email con mail()
            } else {
                $_SESSION["mensaje"] = "Si el email existe, recibirás un enlace para restablecer la contraseña.";
            }

            header("Location: index.php?controller=usuario&action=olvidarPassword");
            exit;
        }
    }

    public function restablecerPassword() {
        $token = $_GET["token"] ?? "";

        $usuario = Usuario::buscarPorToken($token);

        if (!$usuario) {
            echo "El enlace no es válido o ha caducado.";
            exit;
        }

        require_once __DIR__ . "/../views/usuarios/restablecerPassword.php";
    }

    public function guardarNuevaPassword() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $token = $_POST["token"] ?? "";
            $password = $_POST["password"] ?? "";
            $password2 = $_POST["password2"] ?? "";

            if ($password !== $password2) {
                $_SESSION["error"] = "Las contraseñas no coinciden.";
                header("Location: index.php?controller=usuario&action=restablecerPassword&token=$token");
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION["error"] = "La contraseña debe tener al menos 6 caracteres.";
                header("Location: index.php?controller=usuario&action=restablecerPassword&token=$token");
                exit;
            }

            $usuario = Usuario::buscarPorToken($token);

            if (!$usuario) {
                echo "El enlace no es válido o ha caducado.";
                exit;
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            Usuario::actualizarPasswordPorToken($token, $password_hash);

            $_SESSION["mensaje"] = "Contraseña actualizada correctamente. Ya puedes iniciar sesión.";
            header("Location: index.php?controller=usuario&action=login");
            exit;
        }
    }
}

?>