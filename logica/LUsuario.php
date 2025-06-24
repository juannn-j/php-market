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
            if ($password === $row['password']) {  // Comparación directa
                return $row['tipo']; // Devuelve 'A' o 'C'
            }
        }
        return false;
    }

    public function guardar(Usuario $usuario) {
        $nombre = $usuario->getNombre();
        $email = $usuario->getCorreo();
        $password = $usuario->getPass();
        $tipo = $usuario->getTipo(); // 'A' o 'C'

        $db = new DB();
        $cn = $db->conectar();

        $sql = "INSERT INTO usuarios (nombre, email, password, tipo) VALUES (:nombre, :email, :password, 'C')";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':nombre', $nombre);
        $ps->bindParam(':email', $email);
        $ps->bindParam(':password', $password);

        try {
            $ps->execute();
            return $ps->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al guardar usuario: " . $e->getMessage());
            return false;
        }
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
