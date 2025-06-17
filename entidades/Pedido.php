<?php
    class Pedido{
        private $id;
        private $usuario_id;
        private $fecha;
        private $total;
    

    public function __construct($id =0, $usuario_id=0, $fecha= '', $total = 0.0){
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->fecha = $fecha;
        $this->total = $total;
    }
    public function getIdpedido()
    {
        return $this->id;
    }
    public function setIdpedido($id)
    {
        $this->id = $id;
    }
    public function getUsuario_id()
    {
        return $this->usuario_id;
    }
    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
}
?>