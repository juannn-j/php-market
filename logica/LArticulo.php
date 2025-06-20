<?php
require_once '../datos/DB.php';
require_once '../entidades/Articulo.php';
require_once '../interfaces/IArticulo.php';

class LArticulo implements IArticulo {
    
    public function guardar(Articulo $articulo): bool {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url) VALUES (:nombre, :marca, :descripcion, :precio, :stock, :imagen_url)";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':nombre', $articulo->getNombre());
        $ps->bindParam(':marca', $articulo->getMarca());
        $ps->bindParam(':descripcion', $articulo->getDescripcion());
        $ps->bindParam(':precio', $articulo->getPrecio());
        $ps->bindParam(':stock', $articulo->getStock());
        $ps->bindParam(':imagen_url', $articulo->getImagen());

        return $ps->execute();
    }

    public function cargar(): array {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "SELECT * FROM articulos";
        $ps = $cn->prepare($sql);
        $ps->execute();

        return $ps->fetchAll(PDO::FETCH_CLASS, 'Articulo');
    }

    public function actualizar(Articulo $articulo): bool {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "UPDATE articulos SET nombre = :nombre, marca = :marca, descripcion = :descripcion, precio = :precio, stock = :stock, imagen_url = :imagen_url WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':id', $articulo->getIdarticulo());
        $ps->bindParam(':nombre', $articulo->getNombre());
        $ps->bindParam(':marca', $articulo->getMarca());
        $ps->bindParam(':descripcion', $articulo->getDescripcion());
        $ps->bindParam(':precio', $articulo->getPrecio());
        $ps->bindParam(':stock', $articulo->getStock());
        $ps->bindParam(':imagen_url', $articulo->getImagen());

        return $ps->execute();
    }

    public function eliminar(int $id): bool {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "DELETE FROM articulos WHERE id = :id";
        $ps = $cn->prepare($sql);
        return $ps->execute([':id' => $id]);
    }

    public function obtenerPorId(int $id): ?Articulo {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "SELECT * FROM articulos WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':id', $id);
        
        if ($ps->execute()) {
            return $ps->fetchObject('Articulo') ?: null;
        }
    }
}
?>