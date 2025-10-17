<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO huespedes (nombre, apellido, email) VALUES (:nombre, :apellido, :email)");
    $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email]);

    header('Location: guestsList.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Huésped</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout guests-page">
    <header class="header">
        <h1>👥 Crear Nuevo Huésped</h1>
    </header>
    <main class="main">
        <form method="POST" action="addGuest.php" class="form-guest">
            <table class="form-guest-table">
                <tr>
                    <td><label for="nombre">Nombre:</label></td>
                    <td><input type="text" id="nombre" name="nombre" required></td>
                </tr>
                <tr>
                    <td><label for="apellido">Apellido:</label></td>
                    <td><input type="text" id="apellido" name="apellido" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        <button type="submit" class="btn btn-primary">Añadir</button>
                    </td>
                </tr>
            </table>
        </form>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>