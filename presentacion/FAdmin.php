<?php
session_start();
require_once __DIR__ . '/../logica/LArticulo.php';
require_once __DIR__ . '/../entidades/Articulo.php';

// Protección: solo admin
defined('ADMIN_TYPE') or define('ADMIN_TYPE', 'A');
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== ADMIN_TYPE) {
    header('Location: ../index.php');
    exit;
}

$articuloLogic = new LArticulo();
$mensaje = '';

// Eliminar artículo
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    if ($articuloLogic->eliminar($id)) {
        $mensaje = 'Artículo eliminado correctamente.';
    } else {
        $mensaje = 'Error al eliminar el artículo.';
    }
}

// Editar artículo (mostrar datos en el form)
$editando = false;
$articuloEdit = null;
if (isset($_GET['editar'])) {
    $id = (int)$_GET['editar'];
    $articuloEdit = $articuloLogic->obtenerPorId($id);
    $editando = true;
}

// Guardar nuevo o actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = (float)($_POST['precio'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $imagen = $_POST['imagen'] ?? '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

    $articulo = new Articulo($nombre, $marca, $descripcion, $precio, $stock, $imagen);
    if ($id) {
        $articulo->setIdarticulo($id);
        if ($articuloLogic->actualizar($articulo)) {
            $mensaje = 'Artículo actualizado correctamente.';
        } else {
            $mensaje = 'Error al actualizar el artículo.';
        }
    } else {
        if ($articuloLogic->guardar($articulo)) {
            $mensaje = 'Artículo agregado correctamente.';
        } else {
            $mensaje = 'Error al agregar el artículo.';
        }
    }
    // Redireccionar para evitar reenvío del formulario (PRG pattern)
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$articulos = $articuloLogic->cargar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Artículos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../assets/articulos.css">
    <link rel="stylesheet" href="./../assets/fadmin.css">
</head>
<body>

<?php
    include '../templates/navbar.php';
    echo "<br>";
?>

<h1>Gestión de Artículos</h1>
<?php if ($mensaje): ?>
    <div style="background:#e0ffe0; padding:10px; border-radius:5px; margin-bottom:15px; color:#222; text-align:center;">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>
<div class="fadmin-container">
    <div class="crud-form">
        <h2><?= $editando ? 'Editar' : 'Agregar' ?> Artículo</h2>
        <form method="post">
            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($articuloEdit->getIdarticulo()) ?>">
            <?php endif; ?>
            <input type="text" name="nombre" placeholder="Nombre" required value="<?= $editando ? htmlspecialchars($articuloEdit->getNombre()) : '' ?>">
            <input type="text" name="marca" placeholder="Marca" required value="<?= $editando ? htmlspecialchars($articuloEdit->getMarca()) : '' ?>">
            <textarea name="descripcion" placeholder="Descripción" required><?= $editando ? htmlspecialchars($articuloEdit->getDescripcion()) : '' ?></textarea>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required value="<?= $editando ? htmlspecialchars($articuloEdit->getPrecio()) : '' ?>">
            <input type="number" name="stock" placeholder="Stock" required value="<?= $editando ? htmlspecialchars($articuloEdit->getStock()) : '' ?>">
            <input type="text" name="imagen" placeholder="URL de la imagen" value="<?= $editando ? htmlspecialchars($articuloEdit->getImagen()) : '' ?>">
            <button type="submit"><?= $editando ? 'Actualizar' : 'Agregar' ?></button>
            <?php if ($editando): ?>
                <a href="FAdmin.php" style="display:inline-block;margin-top:10px;">Cancelar</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fadmin-catalogo">
        <div class="catalogo">
            <?php foreach ($articulos as $articulo): 
                $imagen = $articulo->getImagen();
            ?>
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
                    <div class="acciones">
                        <a href="?editar=<?= $articulo->getIdarticulo() ?>" style="background:#ffc107;padding:5px 10px;border-radius:4px;text-decoration:none;color:#222;">Editar</a>
                        <a href="?eliminar=<?= $articulo->getIdarticulo() ?>" onclick="return confirm('¿Seguro que deseas eliminar este artículo?');" style="background:#dc3545;padding:5px 10px;border-radius:4px;text-decoration:none;color:#fff;">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php    
    echo "<br>";
    include '../templates/footer.php';
?>
</body>
</html>