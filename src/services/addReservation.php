<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido.';
    exit;
}

$huesped_id = $_POST['guest_id'] ?? null;
$habitacion_id = $_POST['room_id'] ?? null;
$fecha_llegada = $_POST['fecha_llegada'] ?? null;
$fecha_salida = $_POST['fecha_salida'] ?? null;

if (!$huesped_id || !$habitacion_id || !$fecha_llegada || !$fecha_salida) {
    echo 'Faltan datos obligatorios.';
    exit;
}

try {
    $db = Database::getInstance();

    // Verificar si la habitación está ocupada en el rango
    $stmt = $db->prepare("SELECT COUNT(*) FROM reservas WHERE habitacion_id = ? AND NOT (fecha_salida <= ? OR fecha_llegada >= ?)");
    $stmt->execute([$habitacion_id, $fecha_llegada, $fecha_salida]);
    if ((int)$stmt->fetchColumn() > 0) {
        throw new RuntimeException('La habitación ya está reservada en ese rango de fechas.');
    }

    // Obtener precio base
    $stmt = $db->prepare('SELECT precio_base FROM habitaciones WHERE id = ?');
    $stmt->execute([$habitacion_id]);
    $precio_base = $stmt->fetchColumn();
    if ($precio_base === false) throw new RuntimeException('Habitación no encontrada.');

    $dias = max(1, (int)((strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60*60*24)));
    $precio_total = $precio_base * $dias;

    $stmt = $db->prepare('INSERT INTO reservas (huesped_id, habitacion_id, fecha_llegada, fecha_salida, precio_total, estado) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$huesped_id, $habitacion_id, $fecha_llegada, $fecha_salida, $precio_total, 'Pendiente']);

    header('Location: ../views/reservations/reservationsList.php');
    exit;
} catch (Exception $e) {
    echo '<div class="error">Error al crear reserva: '.htmlspecialchars($e->getMessage()).'</div>';
}




