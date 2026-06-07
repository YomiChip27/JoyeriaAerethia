<?php

require_once __DIR__ . "/conexion.php";

class Usuario {

    public static function registrar($nombre, $apellidos, $email, $password) {
        $db = Conexion::conectar();

        $sql = "INSERT INTO usuarios
                (nombre, apellidos, email, password, rol)
                VALUES
                (:nombre, :apellidos, :email, :password, 'user')";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        return $stmt->execute();
    }

    public static function obtenerPorEmail($email) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public static function obtenerPorId($id_usuario) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerTodos($buscar = null, $inicio = null, $limite = null) {
        $db = Conexion::conectar();

        $sql = "SELECT *
                FROM usuarios
                WHERE 1";

        if ($buscar !== null && $buscar !== "") {
            $sql .= " AND (
                nombre LIKE :buscar
                OR apellidos LIKE :buscar
                OR email LIKE :buscar
                OR rol LIKE :buscar
            )";
        }

        $sql .= " ORDER BY id_usuario DESC";

        if ($inicio !== null && $limite !== null) {
            $sql .= " LIMIT :inicio, :limite";
        }

        $stmt = $db->prepare($sql);

        if ($buscar !== null && $buscar !== "") {
            $buscarParam = "%" . $buscar . "%";
            $stmt->bindParam(":buscar", $buscarParam);
        }

        if ($inicio !== null && $limite !== null) {
            $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id, $nombre, $apellidos, $email) {
        $db = Conexion::conectar();

        $sql = "UPDATE usuarios 
                SET nombre = :nombre, 
                    apellidos = :apellidos, 
                    email = :email 
                WHERE id_usuario = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public static function actualizarPassword($id, $nuevaPassword) {
        $db = Conexion::conectar();

        $sql = "UPDATE usuarios 
                SET password = :password 
                WHERE id_usuario = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":password", $nuevaPassword);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public static function actualizarDesdeAdmin($id_usuario, $nombre, $apellidos, $email, $rol) {
        $db = Conexion::conectar();

        $sql = "UPDATE usuarios 
                SET nombre = :nombre,
                    apellidos = :apellidos,
                    email = :email,
                    rol = :rol
                WHERE id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidos", $apellidos);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":rol", $rol);
        $stmt->bindParam(":id_usuario", $id_usuario);

        return $stmt->execute();
    }

    public static function eliminar($id_usuario) {
        $db = Conexion::conectar();

         $sql = "UPDATE usuarios 
            SET activo = 0
            WHERE id_usuario = :id_usuario";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);

        return $stmt->execute();
    }

    public static function reactivar($id_usuario) {
    $db = Conexion::conectar();

    $sql = "UPDATE usuarios
            SET activo = 1
            WHERE id_usuario = :id_usuario";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id_usuario", $id_usuario);

    return $stmt->execute();
}
public static function contar() {
            $db = Conexion::conectar();

            $sql = "SELECT COUNT(*) as total FROM reservas";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"];
        }

        public static function contarTodosFiltrados($buscar = null) {
            $db = Conexion::conectar();

            $sql = "SELECT COUNT(*) AS total
                    FROM usuarios
                    WHERE 1";

            if ($buscar !== null && $buscar !== "") {
                $sql .= " AND (
                    nombre LIKE :buscar
                    OR apellidos LIKE :buscar
                    OR email LIKE :buscar
                    OR rol LIKE :buscar
                )";
            }

            $stmt = $db->prepare($sql);

            if ($buscar !== null && $buscar !== "") {
                $buscarParam = "%" . $buscar . "%";
                $stmt->bindParam(":buscar", $buscarParam);
            }

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
        }
    public static function buscarPorEmail($email) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function guardarTokenReset($email, $token, $fecha_expira) {
        $db = Conexion::conectar();

        $sql = "UPDATE usuarios 
                SET reset_token = :token, reset_expira = :fecha_expira
                WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":fecha_expira", $fecha_expira);
        $stmt->bindParam(":email", $email);

        return $stmt->execute();
    }

    public static function buscarPorToken($token) {
        $db = Conexion::conectar();

        $sql = "SELECT * FROM usuarios 
                WHERE reset_token = :token 
                AND reset_expira > NOW()
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":token", $token);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizarPasswordPorToken($token, $password_hash) {
        $db = Conexion::conectar();

        $sql = "UPDATE usuarios 
                SET password = :password,
                    reset_token = NULL,
                    reset_expira = NULL
                WHERE reset_token = :token";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":token", $token);

        return $stmt->execute();
    }
}


?>