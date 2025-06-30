<?php
// Calcular cantidad de items en el carrito para clientes
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$cantidad = 0;
foreach ($carrito as $item) {
    $cantidad += $item['cantidad'];
}

// Determinar el rol del usuario
$rol = $_SESSION['rol'] ?? null;
$usuario = $_SESSION['login_user'] ?? null;
?>

<nav class="bg-black text-white py-2">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <?php if ($rol === 'A'): ?>
                    <!-- Navegación para Administrador -->
                    <li><a href="../admin.php" class="nav-link px-2 text-white">Gestión Artículos</a></li>
                <?php elseif ($rol === 'C'): ?>
                    <!-- Navegación para Cliente -->
                    <li><a href="../customer.php" class="nav-link px-2 text-white">Venta Laptops</a></li>
                <?php else: ?>
                    <!-- Navegación para usuarios no logueados -->
                    <li><a href="../index.php" class="nav-link px-2 text-white">Venta Laptops</a></li>
                <?php endif; ?>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="../search.php" method="GET">
                <input type="search" name="q" class="form-control form-control-dark text-bg-dark" placeholder="Buscar laptops..."
                    aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </form>

            <div class="text-end d-flex align-items-center gap-2">
                <?php if ($rol === 'C'): ?>
                    <!-- Carrito para clientes -->
                    <a href="../buycar.php" class="btn btn-warning position-relative">
                        🛒
                        <?php if ($cantidad > 0): ?>
                            <span class="badge" style="position:absolute;top:5px;right:5px; background:#dc3545; color:#fff; border-radius:50%; padding:2px 7px; font-size:0.9rem;">
                                <?= $cantidad ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                
                <?php if ($usuario): ?>
                    <!-- Usuario logueado -->
                    <span class="text-white" style="border: 1px solid #fff; padding: 6px 12px; border-radius: 4px; margin-right: 10px;">
                        <?= $rol === 'A' ? 'Admin' : 'Cliente' ?>: <?= htmlspecialchars($usuario) ?>
                    </span>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <!-- Usuario no logueado -->
                    <a href="../login.php" class="btn btn-primary">Iniciar Sesión</a>
                    <a href="../signin.php" class="btn btn-primary">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
