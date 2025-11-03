<?php
session_start();
require_once __DIR__ . '/src/config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM Cuentas WHERE nombre = ? AND contraseña = ?');
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['usuario'] = $user['nombre'];
            // Redirigir a index.php tanto para admin como para marco
            header('Location: index.php');
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
        }
    } catch (Exception $e) {
        $error = 'Error de conexión: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login SGH</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <div class="form-guest">
        <h2>Iniciar sesión</h2>
        <?php if ($error): ?>
            <div class="error"> <?= $error ?> </div>
        <?php endif; ?>
        <form method="post">
            <label for="username">Usuario:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</body>
</html>
