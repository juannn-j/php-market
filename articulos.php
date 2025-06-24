<?php
require_once __DIR__ . '/datos/DB.php';
require_once __DIR__ . '/logica/LArticulo.php';
require_once __DIR__ . '/entidades/Articulo.php';

$articuloLogic = new LArticulo();
$articulos = $articuloLogic->cargar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Catálogo de Artículos</title>
    <link rel="stylesheet" href="assets/articulos.css">
</head>
<body>

<h1>Catálogo de Artículos</h1>
<div class="catalogo">
    <?php foreach ($articulos as $articulo): 
        $imagen = $articulo->getImagen();
    ?>
        <div class="producto">
            <?php if (!empty($imagen)): ?>
                <img src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($articulo->getNombre()); ?>" />
            <?php else: ?>
                <img src="https://via.placeholder.com/250x180?text=Sin+Imagen" alt="Sin Imagen" />
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($articulo->getNombre()); ?></h2>
            <p><strong>Marca:</strong> <?php echo htmlspecialchars($articulo->getMarca()); ?></p>
            <p><?php echo htmlspecialchars($articulo->getDescripcion()); ?></p>
            <div class="precio-stock">
                <span>Precio: $<?php echo number_format($articulo->getPrecio(), 2); ?></span>
                <span>Stock: <?php echo (int)$articulo->getStock(); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
