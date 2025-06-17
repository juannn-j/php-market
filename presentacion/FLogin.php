<?php
require_once '../logica/LUsuario.php';
require_once '../entidades/User.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario($email, $password);
    $modelo = new LUser();

    if ($modelo->validar($usuario)) {
        // Redirige si las credenciales son válidas
        header("Location: bienvenida.php");
        exit; // Importante: detener ejecución
    } else {
        $mensaje = "❌ Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/FLogin.css">

</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <?php if (!empty($mensaje)): ?>
            <p><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>juan@example.com
        </form>
    </div>
</body>
</html>
