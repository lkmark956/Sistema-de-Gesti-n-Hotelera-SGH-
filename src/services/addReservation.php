<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $huesped_id = $_POST['huesped_id'];
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];

    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO reservas (huesped_id, habitacion_id, fecha_llegada, fecha_salida) VALUES (:huesped_id, :habitacion_id, :fecha_llegada, :fecha_salida)");
    $stmt->execute(['huesped_id' => $huesped_id, 'habitacion_id' => $habitacion_id, 'fecha_llegada' => $fecha_llegada, 'fecha_salida' => $fecha_salida]);

    header('Location: reservationsList.php');
}
?>