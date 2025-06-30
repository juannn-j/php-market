<?php

require_once __DIR__ . '/../db.php';

$rol = $_SESSION['rol'] ?? null;
$usuario = $_SESSION['login_user'] ?? null;

$articulos = [];

try {
    $cn = DB::conectar();
    
    $sql = "SELECT * FROM articulos ORDER BY nombre";
    $ps = $cn->prepare($sql);
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
    $error = "Error al cargar los artículos: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="../styles/customer.css">

<div class="container mt-4">
    <h1>Catálogo de Artículos</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($articulos)): ?>
        <div class="alert alert-info">
            No hay artículos disponibles en el catálogo.
        </div>
    <?php else: ?>
        <p>Total de artículos: <strong><?= count($articulos) ?></strong></p>
        
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
                            <a href="../admin.php?editar=<?= $articulo['id'] ?>" style="background:#ffc107;padding:5px 10px;border-radius:4px;text-decoration:none;color:#222;">Editar</a>
                            <a href="../admin.php?eliminar=<?= $articulo['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este artículo?');" style="background:#dc3545;padding:5px 10px;border-radius:4px;text-decoration:none;color:#fff;">Eliminar</a>
                        </div>
                    <?php elseif ($rol === 'C'): ?>
                        <!-- Acciones para Cliente -->
                        <form method="post" action="../customer.php">
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


<div id="modalLogin" class="modal-bg" style="display: none;">
    <div class="modal-box">
        <button class="close" onclick="cerrarModal()">&times;</button>
        <h3>Iniciar Sesión Requerido</h3>
        <p>Para realizar compras, necesitas iniciar sesión en tu cuenta.</p>
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="../login.php" class="btn btn-primary">Iniciar Sesión</a>
            <a href="../signin.php" class="btn btn-outline-primary">Registrarse</a>
            <button onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
        </div>
    </div>
</div>

<script>
function mostrarAlertaLogin() {
    document.getElementById('modalLogin').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalLogin').style.display = 'none';
}

document.getElementById('modalLogin').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
