<?php
session_start();
require_once '../logica/LPedido.php';
require_once '../logica/LDetallePedido.php';
require_once '../entidades/Pedido.php';
require_once '../entidades/DetallePedido.php';

$mensaje = '';
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Eliminar del carrito
if (isset($_POST['eliminar_carrito'])) {
    $id = $_POST['idarticulo'];
    unset($_SESSION['carrito'][$id]);
}

$boleta = [];
// Confirmar pedido
if (isset($_POST['confirmar_pedido']) && !empty($_SESSION['carrito'])) {
    $usuario_id = $_SESSION['login_user_id'] ?? null;
    if ($usuario_id) {
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        $pedido = new Pedido(0, $usuario_id, date('Y-m-d H:i:s'), $total);
        $lPedido = new LPedido();
        $pedido_id = $lPedido->crearPedido($pedido);
        if ($pedido_id) {
            $lDetalle = new LDetallePedido();
            foreach ($_SESSION['carrito'] as $item) {
                $detalle = new DetallePedido(0, $pedido_id, $item['id'], $item['cantidad'], $item['precio']);
                $lDetalle->agregarDetallePedido($detalle);
            }
            $_SESSION['boleta'] = [
                'cliente' => $_SESSION['login_user'] ?? 'Desconocido',
                'fecha' => date('d/m/Y H:i'),
                'items' => $_SESSION['carrito'],
            ];
            $_SESSION['carrito'] = [];
            $mensaje = '¡Pedido realizado con éxito!';
        } else {
            $mensaje = 'Error al guardar el pedido.';
        }
    } else {
        $mensaje = 'Debes iniciar sesión para confirmar el pedido.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../assets/fusuario.css" rel="stylesheet">
    <style>
        .modal-bg {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.35); z-index: 9999; display: flex; align-items: center; justify-content: center;
        }
        .modal-box {
            background: #fff; border-radius: 10px; max-width: 400px; width: 95vw; padding: 30px 24px 20px 24px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); z-index: 10000; position: relative;
        }
        .modal-box .close { position: absolute; top: 12px; right: 18px; font-size: 1.5rem; color: #888; cursor: pointer; background:none; border:none; }
        .boleta-box { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); padding: 30px 24px; }
    </style>
</head>
<body>
    <?php include './navbarcliente.php'; ?>
    <div class="container">
        <div class="carrito-box">
            <h2>Carrito de Compras</h2>
            <?php if (!empty($_SESSION['carrito'])): ?>
                <table class="table">
                    <thead><tr><th>Artículo</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th></th></tr></thead>
                    <tbody>
                    <?php $total = 0; foreach ($_SESSION['carrito'] as $item): $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="idarticulo" value="<?= $item['id'] ?>">
                                    <button type="submit" name="eliminar_carrito" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <h4>Total: $<?= number_format($total, 2) ?></h4>
                <form method="post">
                    <button type="submit" name="confirmar_pedido" class="btn btn-success">Confirmar Pedido</button>
                </form>
            <?php else: ?>
                <p>El carrito está vacío.</p>
            <?php endif; ?>
            <?php if ($mensaje): ?>
                <div class="alert alert-info mt-3"> <?= htmlspecialchars($mensaje) ?> </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['boleta']) && $mensaje === '¡Pedido realizado con éxito!'): ?>
            <div class="boleta-box mt-4">
                <h4>Boleta de Pedido</h4>
                <p><strong>Cliente:</strong> <?= htmlspecialchars($_SESSION['boleta']['cliente']) ?></p>
                <p><strong>Fecha y hora:</strong> <?= htmlspecialchars($_SESSION['boleta']['fecha']) ?></p>
                <table class="table">
                    <thead><tr><th>Artículo</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead>
                    <tbody>
                    <?php $total = 0; foreach ($_SESSION['boleta']['items'] as $item): $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <h5>Total: $<?= number_format($total, 2) ?></h5>
                <p class="text-success">¡Gracias por tu compra!</p>
            </div>
            <?php unset($_SESSION['boleta']); endif; ?>
        </div>
    </div>

<?php    
    echo "<br>";
    include './footer.php';
?>
</body>
</html>
