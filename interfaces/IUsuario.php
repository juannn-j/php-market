<?php
require_once '../entidades/User.php';

interface IUsuario {
    public function guardar(Usuario $usuario);
    public function cargar(): array;

    public function validar(Usuario $usuario): string|false;
    public function obtenerPorId(int $id): ?Usuario;
}
?>
