<?php
require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID de reserva no especificado.";
    exit;
}
$stmt = $db->prepare("SELECT * FROM reservas WHERE id = ?");
$stmt->execute([$id]);
$reservation = $stmt->fetch();

$guests = $db->query("SELECT id, nombre FROM huespedes")->fetchAll();
$rooms = $db->query("SELECT id, numero FROM habitaciones")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout reservations-page">
    <header class="header">
        <h1>📅 Editar Reserva</h1>
    </header>
    <main class="main">
        <form method="POST" action="updateReservation.php" class="form-room">
            <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
            <table class="form-room-table">
                <tr>
                    <td><label for="guest_id">Huésped:</label></td>
                    <td>
                        <select id="guest_id" name="guest_id" required>
                            <?php foreach ($guests as $g): ?>
                                <option value="<?= $g['id'] ?>" <?= ($reservation['huesped_id'] ?? '') == $g['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($g['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="room_id">Habitación:</label></td>
                    <td>
                        <select id="room_id" name="room_id" required>
                            <?php foreach ($rooms as $r): ?>
                                <option value="<?= $r['id'] ?>" <?= ($reservation['habitacion_id'] ?? '') == $r['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['numero']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="fecha_llegada">Fecha llegada:</label></td>
                    <td><input type="date" id="fecha_llegada" name="fecha_llegada" value="<?= htmlspecialchars($reservation['fecha_llegada'] ?? '') ?>" required></td>
                </tr>
                <tr>
                    <td><label for="fecha_salida">Fecha salida:</label></td>
                    <td><input type="date" id="fecha_salida" name="fecha_salida" value="<?= htmlspecialchars($reservation['fecha_salida'] ?? '') ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Actualizar</button>
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