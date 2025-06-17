<?php
interface IPedido {
    public function crearPedido(Pedido $pedido);
    public function obtenerPedidoPorId($id);
    public function obtenerPedidosPorUsuario($usuarioId);
    public function obtenerTodosLosPedidos();
    public function actualizarTotal($pedidoId, $total);
}
?>
