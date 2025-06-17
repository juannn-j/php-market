<?php
class Usuario {
    private $idusuario;
    private $nombre;
    private $email;
    private $password;

    public function __construct($email = '', $password = '') {
        $this->email = $email;
        $this->password = $password;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getCorreo() {
        return $this->email;
    }

    public function setCorreo($email) {
        $this->email = $email;
    }

    public function getPass() {
        return $this->password;
    }

    public function setPass($password) {
        $this->password = $password;
    }
}
?>
