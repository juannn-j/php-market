<?php
session_start();
require_once '../logica/LUsuario.php';
require_once '../entidades/User.php';

$mensaje = '';

// Si el usuario ya inició sesión, redirigir
if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
    header("Location: FUsuario.php");
    exit;
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario($email, $password);
    $modelo = new LUser();

    if ($modelo->validar($usuario)) {
        // Guardar datos en sesión
        $_SESSION['login_user'] = $email;
        $_SESSION['rol'] = 'usuario'; // cambia esto si obtienes el rol del usuario

        header("Location: FUsuario.php");
        exit;
    } else {
        $mensaje = "❌ Credenciales inválidas.";
    }
}
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../assets/FLogin.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

<main class="form-signin text-center w-100 m-auto">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
        <hr>
        <a href="#" class="nav-link px-2 text-primary">¿No tienes cuenta? Regístrate</a>
    </form>
</main>

</body>
</html>
