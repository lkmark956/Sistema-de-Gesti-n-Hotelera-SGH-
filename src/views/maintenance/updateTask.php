<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $habitacion_id = $_POST['habitacion_id'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE tareas_mantenimiento SET habitacion_id = :habitacion_id, descripcion = :descripcion, estado = :estado WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'habitacion_id' => $habitacion_id,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);

        header('Location: tasks.php');
        exit();
    } catch (Exception $e) {
        echo "Error al actualizar la tarea: " . $e->getMessage();
    }
}
?>