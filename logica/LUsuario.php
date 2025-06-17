<?php
require_once '../datos/DB.php';
require_once '../entidades/User.php';
require_once '../interfaces/IUsuario.php';

class LUser implements IUsuario {
    
    public function validar(Usuario $usuario): bool {
        $email = $usuario->getCorreo();
        $password = $usuario->getPass();

        $db = new DB();
        $cn = $db->conectar();

        $sql = "SELECT password FROM usuario WHERE email = :email";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':email', $email);
        $ps->execute();

        if ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            return $password === $row['password']; // o usar password_verify si están hasheadas
        }

        return false;
    }

    public function guardar(Usuario $usuario) {
        // TODO: Implementar lógica para insertar nuevo usuario
    }

    public function actualizar(Usuario $usuario): bool {
        // TODO: Implementar lógica para actualizar un usuario
        return false;
    }

    public function eliminar(int $id): bool {
        // TODO: Implementar lógica para eliminar usuario
        return false;
    }

    public function obtenerPorId(int $id): ?Usuario {
        // TODO: Implementar lógica para obtener usuario por ID
        return null;
    }

    public function cargar(): array {
        // TODO: Implementar lógica para listar todos los usuarios
        return [];
    }
}
?>
