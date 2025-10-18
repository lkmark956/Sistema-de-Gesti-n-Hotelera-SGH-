<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';

$db = Database::getInstance();
$guests = $db->query("SELECT id, nombre FROM huespedes")->fetchAll();
$rooms = $db->query("SELECT id, numero FROM habitaciones")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $huesped_id = $_POST['guest_id'];
    $habitacion_id = $_POST['room_id'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];

    try {
        // Verificar si la habitación ya está reservada en ese rango de fechas
        $stmt = $db->prepare("SELECT COUNT(*) FROM reservas WHERE habitacion_id = ? AND ((fecha_llegada <= ? AND fecha_salida >= ?) OR (fecha_llegada <= ? AND fecha_salida >= ?))");
        $stmt->execute([$habitacion_id, $fecha_llegada, $fecha_llegada, $fecha_salida, $fecha_salida]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            throw new Exception("La habitación ya está reservada en ese rango de fechas.");
        }

        // Obtener el precio base de la habitación
        $stmt = $db->prepare("SELECT precio_base FROM habitaciones WHERE id = ?");
        $stmt->execute([$habitacion_id]);
        $precio_base = $stmt->fetchColumn();

        // Calcular la cantidad de días de la reserva
        $dias = (strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60 * 60 * 24);
        if ($dias < 1) $dias = 1; // Mínimo 1 día

        $precio_total = $precio_base * $dias;

        // Insertar la nueva reserva
        $stmt = $db->prepare("INSERT INTO reservas (huesped_id, habitacion_id, fecha_llegada, fecha_salida, precio_total) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$huesped_id, $habitacion_id, $fecha_llegada, $fecha_salida, $precio_total]);

        header('Location: reservationsList.php');
        exit;
    } catch (Exception $e) {
        echo "<div class='error'>Error al añadir la reserva: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Reserva</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout reservations-page">
    <header class="header">
        <h1>📅 Crear Nueva Reserva</h1>
    </header>
    <main class="main">
        <form method="POST" action="addReservation.php" class="form-room">
            <table class="form-room-table">
                <tr>
                    <td><label for="guest_id">Huésped:</label></td>
                    <td>
                        <select id="guest_id" name="guest_id" required>
                            <?php foreach ($guests as $g): ?>
                                <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="room_id">Habitación:</label></td>
                    <td>
                        <select id="room_id" name="room_id" required>
                            <?php foreach ($rooms as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['numero']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="fecha_llegada">Fecha llegada:</label></td>
                    <td><input type="date" id="fecha_llegada" name="fecha_llegada" required></td>
                </tr>
                <tr>
                    <td><label for="fecha_salida">Fecha salida:</label></td>
                    <td><input type="date" id="fecha_salida" name="fecha_salida" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Guardar Reserva</button>
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