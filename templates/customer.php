<?php
session_start();

// Protección: solo cliente
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'C') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';

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
        try {
            $cn = DB::conectar();
            
            // Calcular total
            $total = 0;
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
            
            // Crear pedido
            $sql = "INSERT INTO pedidos (usuario_id, fecha, total) VALUES (:usuario_id, :fecha, :total) RETURNING id";
            $ps = $cn->prepare($sql);
            $ps->execute([
                ':usuario_id' => $usuario_id,
                ':fecha' => date('Y-m-d H:i:s'),
                ':total' => $total
            ]);
            
            $pedido_id = $cn->lastInsertId();
            
            if ($pedido_id) {
                // Crear detalles del pedido
                foreach ($_SESSION['carrito'] as $item) {
                    $sql = "INSERT INTO pedido_detalles (pedido_id, articulo_id, cantidad, precio_unitario) VALUES (:pedido_id, :articulo_id, :cantidad, :precio)";
                    $ps = $cn->prepare($sql);
                    $ps->execute([
                        ':pedido_id' => $pedido_id,
                        ':articulo_id' => $item['id'],
                        ':cantidad' => $item['cantidad'],
                        ':precio' => $item['precio']
                    ]);
                }
                
                // Guardar boleta en sesión
                $_SESSION['boleta'] = [
                    'pedido_id' => $pedido_id,
                    'cliente' => $_SESSION['login_user'] ?? 'Desconocido',
                    'fecha' => date('d/m/Y H:i'),
                    'items' => $_SESSION['carrito'],
                    'total' => $total
                ];
                
                $_SESSION['carrito'] = [];
                $mensaje = '✅ ¡Pedido realizado con éxito! Pedido #' . $pedido_id;
            } else {
                $mensaje = '❌ Error al guardar el pedido.';
            }
        } catch (PDOException $e) {
            $mensaje = '❌ Error en la base de datos: ' . $e->getMessage();
        }
    } else {
        $mensaje = '❌ Debes iniciar sesión para confirmar el pedido.';
    }
}

// Obtener artículos
$articulos = [];
try {
    $cn = DB::conectar();
    $sql = "SELECT * FROM articulos ORDER BY nombre";
    $ps = $cn->prepare($sql);
    $ps->execute();
    $articulos = $ps->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje = '❌ Error al cargar artículos: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Artículos - Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/customer.css">
    <style>
        .boleta-box {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            padding: 30px 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include './templates/nbar.php'; ?>

<div class="container">
    <h1 class="mt-4">Catálogo de Artículos</h1>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert <?= strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    
    <div class="catalogo">
        <?php foreach ($articulos as $articulo): ?>
            <div class="producto">
                <?php if (!empty($articulo['imagen_url'])): ?>
                    <img src="<?= htmlspecialchars($articulo['imagen_url']) ?>" alt="<?= htmlspecialchars($articulo['nombre']) ?>" />
                <?php else: ?>
                    <img src="https://via.placeholder.com/250x180?text=Sin+Imagen" alt="Sin Imagen" />
                <?php endif; ?>
                <h2><?= htmlspecialchars($articulo['nombre']) ?></h2>
                <p><strong>Marca:</strong> <?= htmlspecialchars($articulo['marca']) ?></p>
                <p><?= htmlspecialchars($articulo['descripcion']) ?></p>
                <div class="precio-stock">
                    <span>Precio: $<?= number_format($articulo['precio'], 2) ?></span>
                    <span>Stock: <?= (int)$articulo['stock'] ?></span>
                </div>
                <form method="post">
                    <input type="hidden" name="idarticulo" value="<?= $articulo['id'] ?>">
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>">
                    <input type="hidden" name="precio" value="<?= $articulo['precio'] ?>">
                    <input type="number" name="cantidad" value="1" min="1" max="<?= (int)$articulo['stock'] ?>">
                    <button type="submit" name="agregar_carrito">Agregar al carrito</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (!empty($_SESSION['boleta']) && strpos($mensaje, '✅') !== false): ?>
        <div class="boleta-box">
            <h4>🎫 Boleta de Pedido</h4>
            <p><strong>Pedido #:</strong> <?= htmlspecialchars($_SESSION['boleta']['pedido_id']) ?></p>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($_SESSION['boleta']['cliente']) ?></p>
            <p><strong>Fecha y hora:</strong> <?= htmlspecialchars($_SESSION['boleta']['fecha']) ?></p>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['boleta']['items'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                            <td>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>$<?= number_format($_SESSION['boleta']['total'], 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            
            <p class="text-success text-center">🎉 ¡Gracias por tu compra!</p>
            <div class="text-center">
                <a href="customer.php" class="btn btn-primary">Continuar comprando</a>
            </div>
        </div>
        <?php unset($_SESSION['boleta']); ?>
    <?php endif; ?>
</div>

<?php include './templates/foot.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
