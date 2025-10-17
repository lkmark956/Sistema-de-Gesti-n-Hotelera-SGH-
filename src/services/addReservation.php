<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $huesped_id = $_POST['huesped_id'];
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];

    try {
        $db = Database::getInstance();

        // Validar que el huesped_id existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM huespedes WHERE id = :huesped_id");
        $stmt->execute(['huesped_id' => $huesped_id]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("El ID del huésped no existe.");
        }

        // Validar que el habitacion_id existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM habitaciones WHERE id = :habitacion_id");
        $stmt->execute(['habitacion_id' => $habitacion_id]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("El ID de la habitación no existe.");
        }

        // Obtener el precio de la habitación
        $stmt = $db->prepare("SELECT precio_base FROM habitaciones WHERE id = :habitacion_id");
        $stmt->execute(['habitacion_id' => $habitacion_id]);
        $precio_base = $stmt->fetchColumn();

        // Calcular la cantidad de días de la reserva
        $dias = (strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60 * 60 * 24);
        $precio_total = $precio_base * $dias;

        // Insertar la nueva reserva
        $stmt = $db->prepare("INSERT INTO reservas (huesped_id, habitacion_id, fecha_llegada, fecha_salida, precio_total) VALUES (:huesped_id, :habitacion_id, :fecha_llegada, :fecha_salida, :precio_total)");
        $stmt->execute([
            'huesped_id' => $huesped_id,
            'habitacion_id' => $habitacion_id,
            'fecha_llegada' => $fecha_llegada,
            'fecha_salida' => $fecha_salida,
            'precio_total' => $precio_total
        ]);

        header('Location: reservationsList.php');
    } catch (Exception $e) {
        echo "Error al añadir la reserva: " . $e->getMessage();
    }
}
?>