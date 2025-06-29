<?php
    // Start session before any output
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['login_user']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'C') {
        $busqueda = $_GET['q'] ?? '';
        $redirect_url = './FBusquedaCliente.php';
        if (!empty($busqueda)) {
            $redirect_url .= '?q=' . urlencode($busqueda);
        }
        header("Location: " . $redirect_url);
        exit();
    } else {
        include '../templates/navbar.php';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/articulos.css">
</head>
<body>

<?php
    require_once '../logica/LArticulo.php';
    require_once '../entidades/Articulo.php';
    
    $busqueda = $_GET['q'] ?? '';
    $articulos = [];
    
    if (!empty($busqueda)) {
        $lArticulo = new LArticulo();
        $articuloBusqueda = new Articulo($busqueda);
        $resultados = $lArticulo->obtenerPorNombre($articuloBusqueda);
        
        foreach ($resultados as $fila) {
            $articulo = new Articulo(
                $fila['nombre'],
                $fila['marca'],
                $fila['descripcion'],
                (float) $fila['precio'],
                (int) $fila['stock'],
                $fila['imagen_url']
            );
            $articulo->setIdarticulo((int) $fila['id']);
            $articulos[] = $articulo;
        }
    }
?>

<div class="container mt-4">
    <h1>Resultados de Búsqueda</h1>
    
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
                        <span>Stock: <?= (int) $articulo->getStock() ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
    
</body>
</html>