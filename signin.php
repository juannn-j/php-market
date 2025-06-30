<?php
session_start();
require_once 'db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $cn = DB::conectar();
        
        // Verificar si el email ya existe
        $sqlCheck = "SELECT id FROM usuarios WHERE email = :email";
        $psCheck = $cn->prepare($sqlCheck);
        $psCheck->bindParam(':email', $email);
        $psCheck->execute();
        
        if ($psCheck->fetch()) {
            $mensaje = "❌ El email ya está registrado.";
        } else {
            $sql = "INSERT INTO usuarios (nombre, email, password, tipo) VALUES (:nombre, :email, :password, 'C')";
            $ps = $cn->prepare($sql);
            $ps->bindParam(':nombre', $nombre);
            $ps->bindParam(':email', $email);
            $ps->bindParam(':password', $password);
            
            if ($ps->execute()) {
                $mensaje = "✅ Usuario registrado exitosamente. <a href='login.php'>Iniciar sesión</a>";
            } else {
                $mensaje = "❌ Error al registrar usuario.";
            }
        }
    } catch (PDOException $e) {
        $mensaje = "❌ Error en la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>👤 Registrar usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/login.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

<main class="form-signin text-center w-100 m-auto">
    <form method="post" action="">
        <h1 class="h3 mb-3 fw-normal">Registrar nuevo usuario</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert <?= strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger' ?> mt-3" role="alert">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <div class="form-floating mb-2">
            <input type="text" class="form-control" id="floatingInput" name="nombre" placeholder="pepito" required>
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
        
        <hr>
        <a href="login.php" class="nav-link px-2 text-primary">¿Ya tienes cuenta? Inicia sesión</a>
        <a href="index.php" class="nav-link px-2 text-secondary">Volver al inicio</a>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
