<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $db = Database::getInstance();
    try {
        // Comprobar si existen reservas asociadas a la habitación
        $check = $db->prepare('SELECT COUNT(*) FROM reservas WHERE habitacion_id = ?');
        $check->execute([$id]);
        if ((int)$check->fetchColumn() > 0) {
            echo '<div class="error">No se puede eliminar la habitación: existen reservas asociadas.</div>';
            exit;
        }

        $stmt = $db->prepare("DELETE FROM habitaciones WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: list.php');
        exit;
    } catch (Exception $e) {
        echo '<div class="error">Error al eliminar la habitación: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>