<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE huespedes SET nombre = :nombre, apellido = :apellido, email = :email WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ]);

        header('Location: guestsList.php');
    } catch (Exception $e) {
        echo "Error al actualizar el huésped: " . $e->getMessage();
    }
}
?>