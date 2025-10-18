<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $habitacion_id = $_POST['habitacion_id'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE tareas_mantenimiento SET habitacion_id = ?, descripcion = ?, estado = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?");
        $stmt->execute([$habitacion_id, $descripcion, $estado, $fecha_inicio, $fecha_fin, $id]);
        header('Location: tasks.php');
        exit();
    } catch (Exception $e) {
        echo "<div class='error'>Error al actualizar la tarea: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>