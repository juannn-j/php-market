<?php
require_once '../entidades/User.php';

interface IUsuario {
    public function guardar(Usuario $usuario);
    public function cargar(): array;
    public function actualizar(Usuario $usuario): bool;
    public function eliminar(int $id): bool;

    public function validar(Usuario $usuario): string|false;
    public function obtenerPorId(int $id): ?Usuario;
}
?>
