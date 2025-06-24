<?php
session_start();

require_once '../logica/LUsuario.php';
require_once '../entidades/User.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = new Usuario(null, $email, $password);
    $modelo = new LUser();

    $tipo = $modelo->validar($usuario);

    if ($tipo) {
        $_SESSION['login_user'] = $email;
        $_SESSION['rol'] = $tipo;
        // Obtener el id del usuario y guardarlo en la sesión
        $db = new DB();
        $cn = $db->conectar();
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $ps = $cn->prepare($sql);
        $ps->bindParam(':email', $email);
        $ps->execute();
        if ($row = $ps->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['login_user_id'] = $row['id'];
        }

        if ($tipo === 'A') {
            header("Location: FAdmin.php");
        } elseif ($tipo === 'C') {
            header("Location: FUsuario.php");
        } else {
            header("Location: FError.php"); // Por si defines otros roles
        }
        exit;
    } else {
        $mensaje = "❌ Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../assets/FLogin.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

<main class="form-signin text-center w-100 m-auto">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Ingrese su correo</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Ingrese su contraseña</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Recordar mi Cuenta</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>
        <hr>
        <a href="./FSignin.php" class="nav-link px-2 text-primary">¿No tienes cuenta? Regístrate</a>
    </form>
</main>
</body>
</html>
