<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO huespedes (nombre, apellido, email) VALUES (:nombre, :apellido, :email)");
    $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email]);

    header('Location: guestsList.php');
}
?>