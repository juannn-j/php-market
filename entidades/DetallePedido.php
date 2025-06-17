<?php
    class DetallePedido{
        private $id;
        private $pedido_id;
        private $articulo_id;
        private $cantidad;
        private $precio_unitario;

        public function __construct($id =0,$pedido_id =0,$articulo_id =0,$cantidad =0,$precio_unitario =0.0){
            $this->id =$id;
            $this->pedido_id =$pedido_id;
            $this->articulo_id =$articulo_id;
            $this->cantidad =$cantidad;
            $this->precio_unitario =$precio_unitario;
            
        }

        public function getIdpedido()
        {
            return $this->pedido_id;
        }
        public function setIdpedido($pedido_id)
        {
            $this->pedido_id=$pedido_id;
        }
        public function getIdarticulo()
        {
            return $this->articulo_id;
        }
        public function setIdarticulo($articulo_id)
        {
            $this->articulo_id =$articulo_id;
        }
        public function getCantidad()
        {
            return $this->cantidad;
        }
        public function setCantidad($cantidad)
        {
            $this->cantidad = $cantidad;
        }
        public function getPrecioUnitario()
        {
            return $this->precio_unitario;
        }
        public function setPrecioUnitario($precio_unitario)
        {
            $this->precio_unitario = $precio_unitario;
        }
    }

?>