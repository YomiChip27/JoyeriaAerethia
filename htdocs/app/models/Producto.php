<?php
require_once __DIR__ . "/conexion.php";

class Producto {

    public static function obtenerTodos($id_categoria = null, $id_piedra = null, $buscar = null, $inicio = null, $limite = null) {
        $db = Conexion::conectar();

        $sql = "SELECT 
                    productos.*,
                    categorias.nombre AS categoria,
                    piedras.nombre AS piedra
                FROM productos
                LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria
                LEFT JOIN piedras ON productos.id_piedra = piedras.id_piedra
                WHERE productos.activo = 1";

        if ($id_categoria !== null && $id_categoria !== "") {
            $sql .= " AND productos.id_categoria = :id_categoria";
        }

        if ($id_piedra !== null && $id_piedra !== "") {
            $sql .= " AND productos.id_piedra = :id_piedra";
        }

        if ($buscar !== null && $buscar !== "") {
            $sql .= " AND (
                productos.nombre LIKE :buscar
                OR productos.descripcion LIKE :buscar
                OR categorias.nombre LIKE :buscar
                OR piedras.nombre LIKE :buscar
            )";
        }

        $sql .= " ORDER BY productos.nombre ASC";

        if ($inicio !== null && $limite !== null) {
            $sql .= " LIMIT :inicio, :limite";
        }

        $stmt = $db->prepare($sql);

        if ($id_categoria !== null && $id_categoria !== "") {
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        }

        if ($id_piedra !== null && $id_piedra !== "") {
            $stmt->bindParam(":id_piedra", $id_piedra, PDO::PARAM_INT);
        }

        if ($buscar !== null && $buscar !== "") {
            $buscarParam = "%" . $buscar . "%";
            $stmt->bindParam(":buscar", $buscarParam);
        }

        if ($inicio !== null && $limite !== null) {
            $stmt->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
            $stmt->bindValue(":limite", (int)$limite, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function contarTodosFiltrados($id_categoria = null, $id_piedra = null, $buscar = null) {
        $db = Conexion::conectar();

        $sql = "SELECT COUNT(*) AS total
                FROM productos
                LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria
                LEFT JOIN piedras ON productos.id_piedra = piedras.id_piedra
                WHERE productos.activo = 1";

        if ($id_categoria !== null && $id_categoria !== "") {
            $sql .= " AND productos.id_categoria = :id_categoria";
        }

        if ($id_piedra !== null && $id_piedra !== "") {
            $sql .= " AND productos.id_piedra = :id_piedra";
        }

        if ($buscar !== null && $buscar !== "") {
            $sql .= " AND (
                productos.nombre LIKE :buscar
                OR productos.descripcion LIKE :buscar
                OR categorias.nombre LIKE :buscar
                OR piedras.nombre LIKE :buscar
            )";
        }

        $stmt = $db->prepare($sql);

        if ($id_categoria !== null && $id_categoria !== "") {
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        }

        if ($id_piedra !== null && $id_piedra !== "") {
            $stmt->bindParam(":id_piedra", $id_piedra, PDO::PARAM_INT);
        }

        if ($buscar !== null && $buscar !== "") {
            $buscarParam = "%" . $buscar . "%";
            $stmt->bindParam(":buscar", $buscarParam);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }

    public static function obtenerPorId($id) {
        $db = Conexion::conectar();

        $sql = "SELECT 
                    productos.*,
                    piedras.nombre AS piedra,
                    categorias.nombre AS categoria
                FROM productos
                LEFT JOIN piedras ON productos.id_piedra = piedras.id_piedra
                LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria
                WHERE productos.id_producto = :id
                AND productos.activo = 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear($nombre, $descripcion, $precio, $stock, $imagen, $exclusivo, $limite_reservas, $id_categoria, $id_piedra) {
        $db = Conexion::conectar();

        $sql = "INSERT INTO productos 
                (nombre, descripcion, precio, stock, imagen, exclusivo, limite_reservas, id_categoria, id_piedra)
                VALUES 
                (:nombre, :descripcion, :precio, :stock, :imagen, :exclusivo, :limite_reservas, :id_categoria, :id_piedra)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":exclusivo", $exclusivo, PDO::PARAM_INT);
        $stmt->bindParam(":limite_reservas", $limite_reservas, PDO::PARAM_INT);
        $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(":id_piedra", $id_piedra, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function actualizar($id_producto, $nombre, $descripcion, $precio, $stock, $imagen, $exclusivo, $limite_reservas, $id_categoria, $id_piedra) {
        $db = Conexion::conectar();

        $sql = "UPDATE productos 
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    stock = :stock,
                    imagen = :imagen,
                    exclusivo = :exclusivo,
                    limite_reservas = :limite_reservas,
                    id_categoria = :id_categoria,
                    id_piedra = :id_piedra
                WHERE id_producto = :id_producto";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
        $stmt->bindParam(":imagen", $imagen);
        $stmt->bindParam(":exclusivo", $exclusivo, PDO::PARAM_INT);
        $stmt->bindParam(":limite_reservas", $limite_reservas, PDO::PARAM_INT);
        $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(":id_piedra", $id_piedra, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function eliminar($id_producto) {
        $db = Conexion::conectar();

        $sql = "UPDATE productos SET activo = 0 WHERE id_producto = :id_producto";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function contar() {
        $db = Conexion::conectar();

        $sql = "SELECT COUNT(*) AS total 
                FROM productos 
                WHERE activo = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }

    public static function obtenerNovedades($limite = 3) {
        $db = Conexion::conectar();

        $sql = "SELECT *
                FROM productos
                WHERE activo = 1
                ORDER BY fecha_creacion DESC
                LIMIT :limite";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerProductosExclusivos() {
        $db = Conexion::conectar();

        $sql = "SELECT *
                FROM productos
                WHERE activo = 1
                AND exclusivo = 1
                ORDER BY nombre ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>