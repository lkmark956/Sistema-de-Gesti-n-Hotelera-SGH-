<?php
require_once __DIR__ . '/../config/database.php';

class EditReservation {
    public static function edit(int $id, int $huesped_id, int $habitacion_id, string $fecha_llegada, string $fecha_salida): bool {
        try {
            $db = Database::getInstance();

            // Obtener el precio de la habitación
            $stmt = $db->prepare("SELECT precio_base FROM habitaciones WHERE id = :habitacion_id");
            $stmt->execute(['habitacion_id' => $habitacion_id]);
            $precio_base = $stmt->fetchColumn();

            // Calcular la cantidad de días de la reserva
            $dias = (strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60 * 60 * 24);
            $precio_total = $precio_base * $dias;

            // Actualizar la reserva
            $stmt = $db->prepare("UPDATE reservas SET huesped_id = :huesped_id, habitacion_id = :habitacion_id, fecha_llegada = :fecha_llegada, fecha_salida = :fecha_salida, precio_total = :precio_total WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'huesped_id' => $huesped_id,
                'habitacion_id' => $habitacion_id,
                'fecha_llegada' => $fecha_llegada,
                'fecha_salida' => $fecha_salida,
                'precio_total' => $precio_total
            ]);

            return true;
        } catch (Exception $e) {
            echo "Error al editar la reserva: " . $e->getMessage();
            return false;
        }
    }
}

$db = Database::getInstance();
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID de reserva no especificado.";
    exit;
}
$stmt = $db->prepare("SELECT * FROM reservations WHERE id = :id");
$stmt->execute(['id' => $id]);
$reservation = $stmt->fetch();

$guests = $db->query("SELECT id, nombre FROM guests")->fetchAll();
$rooms = $db->query("SELECT id, numero FROM rooms")->fetchAll();
?>
<h2>Editar Reserva</h2>
<form method="POST" action="../../services/editReservation.php">
    <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
    <label>Huésped:</label>
    <select name="guest_id" required>
        <?php foreach ($guests as $g): ?>
            <option value="<?= $g['id'] ?>" <?= $g['id'] == $reservation['guest_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($g['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Habitación:</label>
    <select name="room_id" required>
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>" <?= $r['id'] == $reservation['room_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($r['numero']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Fecha llegada:</label>
    <input type="date" name="fecha_llegada" value="<?= $reservation['fecha_llegada'] ?>" required>
    <label>Fecha salida:</label>
    <input type="date" name="fecha_salida" value="<?= $reservation['fecha_salida'] ?>" required>
    <button type="submit">Actualizar</button>
</form>