<?php
session_start();

// Incluir la conexión a base de datos
require_once 'db.php';

// Procesar la búsqueda si se envió
$busqueda = $_GET['q'] ?? '';
$articulos = [];

if (!empty($busqueda)) {
    try {
        $cn = DB::conectar();
        
        // Usar la función similarity de PostgreSQL para búsqueda por similitud
        $sql = "
            SELECT *
            FROM articulos
            WHERE similarity(nombre, :busqueda) > 0.2
            ORDER BY similarity(nombre, :busqueda) DESC
            LIMIT 20
        ";
        
        $ps = $cn->prepare($sql);
        $ps->bindParam(':busqueda', $busqueda);
        $ps->execute();
        
        $resultados = $ps->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($resultados as $fila) {
            $articulos[] = [
                'id' => $fila['id'],
                'nombre' => $fila['nombre'],
                'marca' => $fila['marca'],
                'descripcion' => $fila['descripcion'],
                'precio' => (float) $fila['precio'],
                'stock' => (int) $fila['stock'],
                'imagen_url' => $fila['imagen_url']
            ];
        }
    } catch (PDOException $e) {
        $error = "Error en la búsqueda: " . $e->getMessage();
    }
}

// Determinar el rol del usuario
$rol = $_SESSION['rol'] ?? null;
$usuario = $_SESSION['login_user'] ?? null;

// Inicializar carrito si es cliente
if ($rol === 'C' && !isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar al carrito (solo para clientes)
if ($rol === 'C' && isset($_POST['agregar_carrito'])) {
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/customer.css">
    <?php if ($rol === 'A'): ?>
        <link rel="stylesheet" href="styles/admin.css">
    <?php endif; ?>
</head>
<body>

<?php include './templates/nbar.php'; ?>

<div class="container mt-4">
    <h1>Resultados de Búsqueda</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($busqueda)): ?>
        <p>Buscando: "<strong><?= htmlspecialchars($busqueda) ?></strong>"</p>
        
        <?php if (empty($articulos)): ?>
            <div class="alert alert-info">
                No se encontraron artículos que coincidan con tu búsqueda.
            </div>
        <?php else: ?>
            <p>Se encontraron <?= count($articulos) ?> artículo(s)</p>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning">
            Por favor, ingresa un término de búsqueda.
        </div>
    <?php endif; ?>
    
    <?php if (!empty($articulos)): ?>
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
                        <span>Stock: <?= $articulo['stock'] ?></span>
                    </div>
                    
                    <?php if ($rol === 'A'): ?>
                        <!-- Acciones para Administrador -->
                        <div class="acciones">
                            <a href="admin.php?editar=<?= $articulo['id'] ?>" style="background:#ffc107;padding:5px 10px;border-radius:4px;text-decoration:none;color:#222;">Editar</a>
                            <a href="admin.php?eliminar=<?= $articulo['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este artículo?');" style="background:#dc3545;padding:5px 10px;border-radius:4px;text-decoration:none;color:#fff;">Eliminar</a>
                        </div>
                    <?php elseif ($rol === 'C'): ?>
                        <!-- Acciones para Cliente -->
                        <form method="post">
                            <input type="hidden" name="idarticulo" value="<?= $articulo['id'] ?>">
                            <input type="hidden" name="nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>">
                            <input type="hidden" name="precio" value="<?= $articulo['precio'] ?>">
                            <input type="number" name="cantidad" value="1" min="1" max="<?= (int)$articulo['stock'] ?>">
                            <button type="submit" name="agregar_carrito">Agregar al carrito</button>
                        </form>
                    <?php else: ?>
                        <!-- Acciones para usuarios no logueados -->
                        <div class="acciones-no-login">
                            <input type="number" value="1" min="1" max="<?= (int)$articulo['stock'] ?>">
                            <button type="button" onclick="mostrarAlertaLogin()">Comprar</button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de alerta para login -->
<div id="modalLogin" class="modal-bg" style="display: none;">
    <div class="modal-box">
        <button class="close" onclick="cerrarModal()">&times;</button>
        <h3>Iniciar Sesión Requerido</h3>
        <p>Para realizar compras, necesitas iniciar sesión en tu cuenta.</p>
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
            <a href="signin.php" class="btn btn-primary">Registrarse</a>
            <button onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function mostrarAlertaLogin() {
    document.getElementById('modalLogin').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalLogin').style.display = 'none';
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('modalLogin').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
</body>
</html> 