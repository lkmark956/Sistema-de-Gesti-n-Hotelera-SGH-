<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM reservas WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Redirigir a la lista de reservas después de eliminar
        header('Location: reservationsList.php');
        exit();
    } catch (Exception $e) {
        echo "Error al eliminar la reserva: " . $e->getMessage();
    }
}
?>