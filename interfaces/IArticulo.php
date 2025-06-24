<?php
require_once __DIR__ . '/../entidades/Articulo.php';
interface IArticulo {
    public function guardar(Articulo $articulo): bool;
    public function cargar(): array;
    public function actualizar(Articulo $articulo): bool;
    public function eliminar(int $id): bool;
    
    public function obtenerPorNombre(Articulo $articulo): array;
    
}
?>