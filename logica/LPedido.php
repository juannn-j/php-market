<?php
require_once __DIR__ . '/../datos/DB.php';
require_once __DIR__ . '/../entidades/Pedido.php';
require_once __DIR__ . '/../interfaces/IPedido.php';

class LPedido implements IPedido {
    public function crearPedido(Pedido $pedido) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "INSERT INTO pedidos (usuario_id, fecha, total) VALUES (:usuario_id, :fecha, :total)";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':usuario_id', $pedido->getUsuario_id());
        $ps->bindValue(':fecha', $pedido->getFecha());
        $ps->bindValue(':total', $pedido->getTotal());
        if ($ps->execute()) {
            return $cn->lastInsertId();
        }
        return false;
    }

    public function obtenerPedidoPorId($id) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':id', $id);
        $ps->execute();
        $row = $ps->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Pedido($row['id'], $row['usuario_id'], $row['fecha'], $row['total']);
        }
        return null;
    }

    public function obtenerPedidosPorUsuario($usuarioId) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "SELECT * FROM pedidos WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':usuario_id', $usuarioId);
        $ps->execute();
        $result = [];
        while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Pedido($row['id'], $row['usuario_id'], $row['fecha'], $row['total']);
        }
        return $result;
    }

    public function obtenerTodosLosPedidos() {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "SELECT * FROM pedidos ORDER BY fecha DESC";
        $ps = $cn->query($sql);
        $result = [];
        while ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Pedido($row['id'], $row['usuario_id'], $row['fecha'], $row['total']);
        }
        return $result;
    }

    public function actualizarTotal($pedidoId, $total) {
        $db = new DB();
        $cn = $db->conectar();
        $sql = "UPDATE pedidos SET total = :total WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->bindValue(':total', $total);
        $ps->bindValue(':id', $pedidoId);
        return $ps->execute();
    }
}
