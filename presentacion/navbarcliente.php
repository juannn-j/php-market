<?php
// Session is now started in the main file, so we don't need to start it here
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$cantidad = 0;
foreach ($carrito as $item) {
    $cantidad += $item['cantidad'];
}
?>
<nav class="bg-black text-white py-2">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Catálogo</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Mis Pedidos</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="./FBusqueda.php" method="GET">
                <input type="search" name="q" class="form-control form-control-dark text-bg-dark" placeholder="Buscar..."
                    aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </form>

            <div class="text-end d-flex align-items-center gap-2">
                <a href="./FDetallePedido.php" class="btn btn-warning position-relative">
                    🛒
                    <?php if ($cantidad > 0): ?>
                        <span class="badge" style="position:absolute;top:5px;right:5px; background:#dc3545; color:#fff; border-radius:50%; padding:2px 7px; font-size:0.9rem;">
                            <?= $cantidad ?>
                        </span>
                    <?php endif; ?>
                </a>
                <a href="./logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- Modal flotante del carrito -->
<div id="modalCarrito" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:10000; align-items:center; justify-content:center;">
    <div style="position:relative; max-width:650px; width:95vw; margin:auto; background:#fff; border-radius:10px; box-shadow:0 8px 32px rgba(0,0,0,0.18); padding:0;">
        <button onclick="cerrarCarrito()" style="position:absolute; top:10px; right:18px; font-size:1.5rem; color:#888; background:none; border:none; cursor:pointer;">&times;</button>
        <iframe id="iframeCarrito" src="" style="width:100%; height:500px; border:none; border-radius:10px;"></iframe>
    </div>
</div>
<script>
function mostrarCarrito() {
    document.getElementById('modalCarrito').style.display = 'flex';
    document.getElementById('iframeCarrito').src = 'FCarrito.php';
}
function cerrarCarrito() {
    document.getElementById('modalCarrito').style.display = 'none';
    document.getElementById('iframeCarrito').src = '';
}
window.cerrarCarrito = cerrarCarrito;
</script> 