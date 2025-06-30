<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol = $_POST['rol'] ?? '';
    
    if ($rol === 'A') {
        header("Location: admin.php");
        exit;
    } elseif ($rol === 'C') {
        header("Location: customer.php");
        exit;
    } else {
        $mensaje = "❌ Selecciona un rol válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Rol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/login.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

<main class="form-signin text-center w-100 m-auto">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Seleccionar Rol</h1>
        <p class="text-muted">Bienvenido, <?= htmlspecialchars($_SESSION['login_user']) ?></p>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <div class="d-grid gap-2">
            <button type="submit" name="rol" value="A" class="btn btn-primary btn-lg">
                <i class="bi bi-person-gear"></i> Administrador
            </button>
            
            <button type="submit" name="rol" value="C" class="btn btn-success btn-lg">
                <i class="bi bi-person"></i> Cliente
            </button>
        </div>
        
        <hr>
        <a href="logout.php" class="nav-link px-2 text-danger">Cerrar sesión</a>
        <a href="index.php" class="nav-link px-2 text-secondary">Volver al inicio</a>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
