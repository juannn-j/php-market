<?php
class Usuario {
    private $idusuario;
    private $nombre;
    private $email;
    private $password;
    private $tipo;


    public function __construct($nombre = '', $email = '', $password = '') {
        $this->nombre = $nombre;
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

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}
?>