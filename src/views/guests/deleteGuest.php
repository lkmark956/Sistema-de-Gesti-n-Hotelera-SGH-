<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM huespedes WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: guestsList.php');
    } catch (Exception $e) {
        echo "Error al eliminar el huésped: " . $e->getMessage();
    }
}
?>