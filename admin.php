<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'A') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';

$mensaje = '';

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    try {
        $cn = DB::conectar();
        
        $cn->beginTransaction();
        
        $sql1 = "DELETE FROM pedido_detalles WHERE articulo_id = :id";
        $ps1 = $cn->prepare($sql1);
        $ps1->execute([':id' => $id]);
        
        $sql2 = "DELETE FROM articulos WHERE id = :id";
        $ps2 = $cn->prepare($sql2);
        $ps2->execute([':id' => $id]);
        
        $cn->commit();
        $mensaje = '✅ Artículo eliminado correctamente.';
    } catch (PDOException $e) {
        $cn->rollBack();
        $mensaje = '❌ Error al eliminar el artículo: ' . $e->getMessage();
    }
}

$editando = false;
$articuloEdit = null;
if (isset($_GET['editar'])) {
    $id = (int)$_GET['editar'];
    try {
        $cn = DB::conectar();
        $sql = "SELECT * FROM articulos WHERE id = :id";
        $ps = $cn->prepare($sql);
        $ps->execute([':id' => $id]);
        $articuloEdit = $ps->fetch(PDO::FETCH_ASSOC);
        $editando = true;
    } catch (PDOException $e) {
        $mensaje = '❌ Error al cargar artículo: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = (float)($_POST['precio'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $imagen = $_POST['imagen'] ?? '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

    try {
        $cn = DB::conectar();
        
        if ($id) {
            $sql = "UPDATE articulos SET nombre = :nombre, marca = :marca, descripcion = :descripcion, precio = :precio, stock = :stock, imagen_url = :imagen WHERE id = :id";
            $ps = $cn->prepare($sql);
            $ps->execute([
                ':nombre' => $nombre,
                ':marca' => $marca,
                ':descripcion' => $descripcion,
                ':precio' => $precio,
                ':stock' => $stock,
                ':imagen' => $imagen,
                ':id' => $id
            ]);
            $mensaje = '✅ Artículo actualizado correctamente.';
        } else {
            $sql = "INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url) VALUES (:nombre, :marca, :descripcion, :precio, :stock, :imagen)";
            $ps = $cn->prepare($sql);
            $ps->execute([
                ':nombre' => $nombre,
                ':marca' => $marca,
                ':descripcion' => $descripcion,
                ':precio' => $precio,
                ':stock' => $stock,
                ':imagen' => $imagen
            ]);
            $mensaje = '✅ Artículo agregado correctamente.';
        }
        
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        $mensaje = '❌ Error en la base de datos: ' . $e->getMessage();
    }
}

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
    <title>🧑‍💻 Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/all.css">
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>

<?php include './templates/nbar.php'; ?>

<div class="container mt-4">
    <h1>Gestión de Artículos</h1>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert <?= strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    
    <div class="fadmin-container">
        <div class="crud-form">
            <h2><?= $editando ? 'Editar' : 'Agregar' ?> Artículo</h2>
            <form method="post">
                <?php if ($editando): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($articuloEdit['id']) ?>">
                <?php endif; ?>
                <input type="text" name="nombre" placeholder="Nombre" required value="<?= $editando ? htmlspecialchars($articuloEdit['nombre']) : '' ?>">
                <input type="text" name="marca" placeholder="Marca" required value="<?= $editando ? htmlspecialchars($articuloEdit['marca']) : '' ?>">
                <textarea name="descripcion" placeholder="Descripción" required><?= $editando ? htmlspecialchars($articuloEdit['descripcion']) : '' ?></textarea>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required value="<?= $editando ? htmlspecialchars($articuloEdit['precio']) : '' ?>">
                <input type="number" name="stock" placeholder="Stock" required value="<?= $editando ? htmlspecialchars($articuloEdit['stock']) : '' ?>">
                <input type="text" name="imagen" placeholder="URL de la imagen" value="<?= $editando ? htmlspecialchars($articuloEdit['imagen_url']) : '' ?>">
                <button type="submit"><?= $editando ? 'Actualizar' : 'Agregar' ?></button>
                <?php if ($editando): ?>
                    <a href="admin.php">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="fadmin-catalogo">
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
                        <div class="acciones">
                            <a href="?editar=<?= $articulo['id'] ?>" style="background:#ffc107;padding:5px 10px;border-radius:4px;text-decoration:none;color:#222;">Editar</a>
                            <a href="?eliminar=<?= $articulo['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este artículo?');" style="background:#dc3545;padding:5px 10px;border-radius:4px;text-decoration:none;color:#fff;">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include './templates/foot.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
