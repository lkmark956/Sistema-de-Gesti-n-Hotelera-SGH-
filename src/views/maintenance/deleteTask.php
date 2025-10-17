<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM tareas_mantenimiento WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: tasks.php');
        exit();
    } catch (Exception $e) {
        echo "Error al eliminar la tarea: " . $e->getMessage();
    }
}
?>