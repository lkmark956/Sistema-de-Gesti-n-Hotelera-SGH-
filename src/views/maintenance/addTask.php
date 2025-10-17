<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitacion_id = $_POST['habitacion_id'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO tareas_mantenimiento (habitacion_id, descripcion, fecha_inicio, fecha_fin) VALUES (:habitacion_id, :descripcion, :fecha_inicio, :fecha_fin)");
    $stmt->execute(['habitacion_id' => $habitacion_id, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]);

    header('Location: tasks.php');
}
?>