<?php
require_once __DIR__ . '/../../config/database.php';

$huesped = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM huespedes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $huesped = $stmt->fetch();
    } catch (Exception $e) {
        $error = "Error al cargar los datos del huésped: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Huésped</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout guests-page">
    <header class="header">
        <h1>👥 Editar Huésped</h1>
    </header>
    <main class="main">
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php elseif ($huesped): ?>
            <form method="POST" action="updateGuest.php" class="form-guest">
                <input type="hidden" name="id" value="<?= htmlspecialchars($huesped['id']) ?>">
                <table class="form-guest-table">
                    <tr>
                        <td><label for="nombre">Nombre:</label></td>
                        <td><input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($huesped['nombre']) ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="apellido">Apellido:</label></td>
                        <td><input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($huesped['apellido']) ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email:</label></td>
                        <td><input type="email" id="email" name="email" value="<?= htmlspecialchars($huesped['email']) ?>" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php endif; ?>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>