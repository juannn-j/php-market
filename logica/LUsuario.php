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
            return $password === $row['password'];
        }

        return false;
    }
}
?>
