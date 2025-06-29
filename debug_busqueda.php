<?php
require_once __DIR__ . '/logica/LArticulo.php';
require_once __DIR__ . '/entidades/Articulo.php';

echo "<h2>Debug de Búsqueda</h2>";

$articuloLogic = new LArticulo();

// Probar búsqueda
$termino = $_GET['q'] ?? 'laptop';
echo "<p>Buscando: '$termino'</p>";

$articuloBusqueda = new Articulo($termino);
$resultados = $articuloLogic->obtenerPorNombre($articuloBusqueda);

echo "<p>Resultados encontrados: " . count($resultados) . "</p>";

if (count($resultados) > 0) {
    echo "<ul>";
    foreach ($resultados as $articulo) {
        echo "<li>" . $articulo->getNombre() . " - " . $articulo->getMarca() . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No se encontraron resultados</p>";
}

// Mostrar todos los artículos para comparar
echo "<h3>Todos los artículos en la base de datos:</h3>";
$todos = $articuloLogic->cargar();
echo "<p>Total de artículos: " . count($todos) . "</p>";
echo "<ul>";
foreach ($todos as $articulo) {
    echo "<li>" . $articulo->getNombre() . " - " . $articulo->getMarca() . "</li>";
}
echo "</ul>";
?> 