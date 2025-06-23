<?php
require_once '../datos/DB.php';
require_once '../entidades/User.php';
require_once '../interfaces/IUsuario.php';

class LUser implements IUsuario {
    
    public function validar(Usuario $usuario): string|false {
        $email = $usuario->getCorreo();
        $password = $usuario->getPass();
    
        $db = new DB();
        $cn = $db->conectar();
    
        $sql = "SELECT password, tipo FROM usuarios WHERE email = :email";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':email', $email);
        $ps->execute();
    
        if ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['password'])) {
                return $row['tipo']; // Devuelve 'A' o 'C'
            }
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
