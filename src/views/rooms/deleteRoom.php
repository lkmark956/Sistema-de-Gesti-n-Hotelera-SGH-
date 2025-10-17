<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $db = Database::getInstance();
    $stmt = $db->prepare("DELETE FROM habitaciones WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header('Location: list.php');
}
?>