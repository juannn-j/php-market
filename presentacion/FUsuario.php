<?php
session_start();
require_once '../logica/LPedido.php';
require_once '../logica/LDetallePedido.php';
require_once '../entidades/Pedido.php';
require_once '../entidades/DetallePedido.php';
require_once '../datos/DB.php';
require_once '../logica/LArticulo.php';

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar al carrito
if (isset($_POST['agregar_carrito'])) {
    $id = $_POST['idarticulo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    // Si ya existe, sumar cantidad
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad
        ];
    }
}

// Eliminar del carrito
if (isset($_POST['eliminar_carrito'])) {
    $id = $_POST['idarticulo'];
    unset($_SESSION['carrito'][$id]);
}

// Confirmar pedido
$mensaje = '';
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
            $_SESSION['carrito'] = [];
            $mensaje = '¡Pedido realizado con éxito!';
        } else {
            $mensaje = 'Error al guardar el pedido.';
        }
    } else {
        $mensaje = 'Debes iniciar sesión para confirmar el pedido.';
    }
}

// Obtener artículos (simulado, deberías traer de la BD)
$lArticulo = new LArticulo();
$articulos = $lArticulo->cargar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario - Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../assets/fusuario.css" rel="stylesheet">
</head>

<body>

    <div>
        <?php
        include './navbarcliente.php';
        ?>
    </div>

    <div class="container">
        <h1 class="mt-4">Catálogo de Artículos</h1>
        <div class="catalogo">
            <?php foreach ($articulos as $articulo): ?>
                <?php $imagen = $articulo->getImagen(); ?>
                <div class="producto">
                    <?php if (!empty($imagen)): ?>
                        <img src="<?= htmlspecialchars($imagen) ?>" alt="<?= htmlspecialchars($articulo->getNombre()) ?>" />
                    <?php else: ?>
                        <img src="https://via.placeholder.com/250x180?text=Sin+Imagen" alt="Sin Imagen" />
                    <?php endif; ?>
                    <h2><?= htmlspecialchars($articulo->getNombre()) ?></h2>
                    <p><strong>Marca:</strong> <?= htmlspecialchars($articulo->getMarca()) ?></p>
                    <p><?= htmlspecialchars($articulo->getDescripcion()) ?></p>
                    <div class="precio-stock">
                        <span>Precio: $<?= number_format($articulo->getPrecio(), 2) ?></span>
                        <span>Stock: <?= (int)$articulo->getStock() ?></span>
                    </div>
                    <form method="post">
                        <input type="hidden" name="idarticulo" value="<?= $articulo->getIdarticulo() ?>">
                        <input type="hidden" name="nombre" value="<?= htmlspecialchars($articulo->getNombre()) ?>">
                        <input type="hidden" name="precio" value="<?= $articulo->getPrecio() ?>">
                        <input type="number" name="cantidad" value="1" min="1" max="<?= (int)$articulo->getStock() ?>">
                        <button type="submit" name="agregar_carrito">Agregar al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
                        
    </div>

</body>

</html>