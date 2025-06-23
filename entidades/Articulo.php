<?php
class Articulo {
    private $idarticulo;
    private $nombre;
    private $marca;
    private $descripcion;
    private $precio;
    private $stock;
    private $imagen;

    public function __construct($nombre = '', $marca = '', $descripcion = '', $precio = 0.0, $stock = 0, $imagen = '') {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->stock= $stock;
        $this->imagen = $imagen;
    }

    public function getIdarticulo() {
        return $this->idarticulo;
    }

    public function setIdarticulo($idarticulo) {
        $this->idarticulo = $idarticulo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
?>