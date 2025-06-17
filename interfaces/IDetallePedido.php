<?php
interface IPedidoDetalle {
    public function agregarDetallePedido(DetallePedido $detalle);
    public function obtenerDetallesPorPedido($pedidoId);
}
?>
