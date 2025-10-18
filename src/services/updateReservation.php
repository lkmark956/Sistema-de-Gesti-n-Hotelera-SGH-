<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido.';
    exit;
}

$id = $_POST['id'] ?? null;
$huesped_id = $_POST['guest_id'] ?? null;
$habitacion_id = $_POST['room_id'] ?? null;
$fecha_llegada = $_POST['fecha_llegada'] ?? null;
$fecha_salida = $_POST['fecha_salida'] ?? null;

if (!$id || !$huesped_id || !$habitacion_id || !$fecha_llegada || !$fecha_salida) {
    echo 'Faltan datos obligatorios.';
    exit;
}

try {
    $db = Database::getInstance();

    // Obtener precio base
    $stmt = $db->prepare('SELECT precio_base FROM habitaciones WHERE id = ?');
    $stmt->execute([$habitacion_id]);
    $precio_base = $stmt->fetchColumn();
    if ($precio_base === false) throw new RuntimeException('Habitación no encontrada.');

    $dias = max(1, (int)((strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60*60*24)));
    $precio_total = $precio_base * $dias;

    $stmt = $db->prepare('UPDATE reservas SET huesped_id = ?, habitacion_id = ?, fecha_llegada = ?, fecha_salida = ?, precio_total = ? WHERE id = ?');
    $stmt->execute([$huesped_id, $habitacion_id, $fecha_llegada, $fecha_salida, $precio_total, $id]);

    header('Location: ../views/reservations/reservationsList.php');
    exit;
} catch (Exception $e) {
    echo '<div class="error">Error al actualizar reserva: '.htmlspecialchars($e->getMessage()).'</div>';
}
