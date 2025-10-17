<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$guests = $db->query("SELECT id, nombre FROM guests")->fetchAll();
$rooms = $db->query("SELECT id, numero FROM rooms")->fetchAll();
?>
<h2>Agregar Reserva</h2>
<form method="POST" action="../../services/addReservation.php">
    <label>Huésped:</label>
    <select name="guest_id" required>
        <?php foreach ($guests as $g): ?>
            <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Habitación:</label>
    <select name="room_id" required>
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['numero']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Fecha llegada:</label>
    <input type="date" name="fecha_llegada" required>
    <label>Fecha salida:</label>
    <input type="date" name="fecha_salida" required>
    <button type="submit">Guardar</button>
</form>