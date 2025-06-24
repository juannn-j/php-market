<?php
require_once __DIR__ . '/../datos/DB.php';
require_once __DIR__ . '/../entidades/DetallePedido.php';
require_once __DIR__ . '/../interfaces/IDetallePedido.php';

class LDetallePedido implements IPedidoDetalle {
    public function agregarDetallePedido(DetallePedido $detalle) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "INSERT INTO pedido_detalles (pedido_id, articulo_id, cantidad, precio_unitario) VALUES (:pedido_id, :articulo_id, :cantidad, :precio_unitario)";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':pedido_id', $detalle->getIdpedido());
        $ps->bindValue(':articulo_id', $detalle->getIdarticulo());
        $ps->bindValue(':cantidad', $detalle->getCantidad());
        $ps->bindValue(':precio_unitario', $detalle->getPrecioUnitario());
        return $ps->execute();
    }

    public function obtenerDetallesPorPedido($pedidoId) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "SELECT * FROM pedido_detalles WHERE pedido_id = :pedido_id";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':pedido_id', $pedidoId);
        $ps->execute();
        $result = [];
        while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new DetallePedido($row['id'], $row['pedido_id'], $row['articulo_id'], $row['cantidad'], $row['precio_unitario']);
        }
        return $result;
    }
}
