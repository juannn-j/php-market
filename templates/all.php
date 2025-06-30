<?php
// Incluir la conexión a base de datos
require_once __DIR__ . '/../db.php';

// Obtener todos los artículos
$articulos = [];

try {
    $cn = DB::conectar();
    
    // Consulta para obtener todos los artículos
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

<link rel="stylesheet" href="../styles/all.css">

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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
