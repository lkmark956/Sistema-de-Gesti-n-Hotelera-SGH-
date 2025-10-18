<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $huesped_id = $_POST['guest_id'];
    $habitacion_id = $_POST['room_id'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];

    $db = Database::getInstance();

    // Obtener el precio base de la habitación
    $stmt = $db->prepare("SELECT precio_base FROM habitaciones WHERE id = ?");
    $stmt->execute([$habitacion_id]);
    $precio_base = $stmt->fetchColumn();

    // Calcular la cantidad de días de la reserva
    $dias = (strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60 * 60 * 24);
    if ($dias < 1) $dias = 1; // Mínimo 1 día

    $precio_total = $precio_base * $dias;

    // Actualizar la reserva
    $stmt = $db->prepare("UPDATE reservas SET huesped_id = ?, habitacion_id = ?, fecha_llegada = ?, fecha_salida = ?, precio_total = ? WHERE id = ?");
    $stmt->execute([$huesped_id, $habitacion_id, $fecha_llegada, $fecha_salida, $precio_total, $id]);

    // Redirigir a la lista de reservas
    header("Location: reservationsList.php");
    exit;
} else {
    echo "Método no permitido.";
}
?>