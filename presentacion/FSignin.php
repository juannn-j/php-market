<?php
session_start();
require_once '../logica/LUsuario.php';
require_once '../entidades/User.php';
require_once '../datos/DB.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario($nombre, $email, $password);
    $modelo = new LUser();

    if ($modelo->guardar($usuario)) {
        header("Location: FUsuario.php"); // o página de éxito
        exit;
    } else {
        $mensaje = "❌ Error al registrar usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../assets/FLogin.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

<main class="form-signin text-center w-100 m-auto">
    <form method="post" action="">
        <h1 class="h3 mb-3 fw-normal">Registrar nuevo usuario</h1>

        <div class="form-floating mb-2">
            <input type="nombre" class="form-control" id="floatingInput" name="nombre" placeholder="pepito" required>
            <label for="floatingInput">Nombre</label>
        </div>

        <div class="form-floating mb-2">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
            <label for="floatingInput">Correo electrónico</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Contraseña" required>
            <label for="floatingPassword">Contraseña</label>
        </div>

        <button class="btn btn-success w-100 py-2" type="submit">Crear cuenta</button>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>
    </form>
</main>

</body>
</html>

