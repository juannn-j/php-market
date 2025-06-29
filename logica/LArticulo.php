<?php
require_once __DIR__ . '/../datos/DB.php';
require_once __DIR__ . '/../entidades/Articulo.php';
require_once __DIR__ . '/../interfaces/IArticulo.php';

class LArticulo implements IArticulo
{

    public function guardar(Articulo $articulo): bool
    {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url) VALUES (:nombre, :marca, :descripcion, :precio, :stock, :imagen_url)";
        $ps = $cn->prepare($sql);
        $nombre = $articulo->getNombre();
        $marca = $articulo->getMarca();
        $descripcion = $articulo->getDescripcion();
        $precio = $articulo->getPrecio();
        $stock = $articulo->getStock();
        $imagen = $articulo->getImagen();
        $ps->bindParam(':nombre', $nombre);
        $ps->bindParam(':marca', $marca);
        $ps->bindParam(':descripcion', $descripcion);
        $ps->bindParam(':precio', $precio);
        $ps->bindParam(':stock', $stock);
        $ps->bindParam(':imagen_url', $imagen);

        return $ps->execute();
    }

    public function cargar(): array
    {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "SELECT * FROM articulos";
        $ps = $cn->prepare($sql);
        $ps->execute();

        $resultados = $ps->fetchAll(PDO::FETCH_ASSOC);
        $articulos = [];

        foreach ($resultados as $fila) {
            $articulo = new Articulo(
                $fila['nombre'],
                $fila['marca'],
                $fila['descripcion'],
                (float)$fila['precio'],
                (int)$fila['stock'],
                $fila['imagen_url']
            );
            $articulo->setIdarticulo((int)$fila['id']);
            $articulos[] = $articulo;
        }

        return $articulos;
    }

    public function actualizar(Articulo $articulo): bool
    {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "UPDATE articulos SET nombre = :nombre, marca = :marca, descripcion = :descripcion, precio = :precio, stock = :stock, imagen_url = :imagen_url WHERE id = :id";
        $ps = $cn->prepare($sql);
        
        $id = $articulo->getIdarticulo();
        $nombre = $articulo->getNombre();
        $marca = $articulo->getMarca();
        $descripcion = $articulo->getDescripcion();
        $precio = $articulo->getPrecio();
        $stock = $articulo->getStock();
        $imagen = $articulo->getImagen();
        
        $ps->bindParam(':id', $id);
        $ps->bindParam(':nombre', $nombre);
        $ps->bindParam(':marca', $marca);
        $ps->bindParam(':descripcion', $descripcion);
        $ps->bindParam(':precio', $precio);
        $ps->bindParam(':stock', $stock);
        $ps->bindParam(':imagen_url', $imagen);

        return $ps->execute();
    }

    public function eliminar(int $id): bool
    {
        $db = new DB();
        $cn = $db->conectar();

        try {
            // Iniciar transacción
            $cn->beginTransaction();

            // 1. Eliminar detalles del pedido relacionados al artículo
            $sql1 = "DELETE FROM pedido_detalles WHERE articulo_id = :id";
            $ps1 = $cn->prepare($sql1);
            $ps1->execute([':id' => $id]);

            // 2. Eliminar el artículo
            $sql2 = "DELETE FROM articulos WHERE id = :id";
            $ps2 = $cn->prepare($sql2);
            $ps2->execute([':id' => $id]);

            // 3. Eliminar pedidos que ya no tienen detalles (huérfanos)
            $sql3 = "
                    DELETE FROM pedidos
                    WHERE id IN (
                        SELECT p.id
                        FROM pedidos p
                        LEFT JOIN pedido_detalles pd ON p.id = pd.pedido_id
                        WHERE pd.id IS NULL
                    )
                ";
            $ps3 = $cn->prepare($sql3);
            $ps3->execute();

            // Confirmar transacción
            $cn->commit();
            return true;
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $cn->rollBack();
            error_log("Error al eliminar artículo: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorNombre(Articulo $articulo): array
    {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "
                SELECT *
                FROM articulos
                WHERE similarity(nombre, :busqueda) > 0.2
                ORDER BY similarity(nombre, :busqueda) DESC
                LIMIT 20;       
            ";

        $ps = $cn->prepare($sql);

        $busquedaLike = '%' . $articulo->getNombre() . '%';  // Agregar % para búsqueda LIKE
        $ps->bindParam(':busqueda', $busquedaLike);

        $ps->execute();
        $resultados = $ps->fetchAll(PDO::FETCH_ASSOC);
        
        $articulos = [];
        foreach ($resultados as $fila) {
            $art = new Articulo(
                $fila['nombre'],
                $fila['marca'],
                $fila['descripcion'],
                (float)$fila['precio'],
                (int)$fila['stock'],
                $fila['imagen_url']
            );
            $art->setIdarticulo((int)$fila['id']);
            $articulos[] = $art;
        }

        return $articulos;
    }

    public function obtenerPorId(int $id): ?Articulo
    {
        $db = new DB();
        $cn = $db->conectar();

        $sql = "SELECT * FROM articulos WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':id', $id);

        if ($ps->execute()) {
            $fila = $ps->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                $articulo = new Articulo(
                    $fila['nombre'],
                    $fila['marca'],
                    $fila['descripcion'],
                    (float)$fila['precio'],
                    (int)$fila['stock'],
                    $fila['imagen_url']
                );
                $articulo->setIdarticulo((int)$fila['id']);

                return $articulo;
            }
        }
        return null;
    }
}
