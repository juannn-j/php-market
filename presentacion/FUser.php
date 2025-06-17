<?php
require_once '../logica/LUser.php';
require_once '../entidades/User.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario($email, $password);
    $modelo = new LUser();

    if ($modelo->validar($usuario)) {
        // Aquí podrías redirigir o iniciar sesión
        $mensaje = "✅ ¡Bienvenido!";
        // header("Location: dashboard.php"); exit;
    } else {
        $mensaje = "❌ Credenciales inválidas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <?php if (!empty($mensaje)): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
