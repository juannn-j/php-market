<?php
require_once './datos/DB.php';
require_once './logica/LArticulo.php';
require_once './entidades/Articulo.php';

$articuloLogic = new LArticulo();
$articulos = $articuloLogic->cargar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Catálogo de Artículos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .catalogo {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .producto {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .producto img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            border-bottom: 1px solid #ddd;
            margin-bottom: 12px;
            border-radius: 4px;
        }
        .producto h2 {
            font-size: 1.2rem;
            margin: 0 0 10px;
        }
        .producto p {
            flex-grow: 1;
            margin: 0 0 10px;
            color: #555;
            font-size: 0.9rem;
        }
        .precio-stock {
            font-weight: bold;
            font-size: 1rem;
            color: #222;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<h1>Catálogo de Artículos</h1>
<div class="catalogo">
    <?php foreach ($articulos as $articulo): 
        $imagen = property_exists($articulo, 'imagen_url') ? $articulo->imagen_url : '';
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
