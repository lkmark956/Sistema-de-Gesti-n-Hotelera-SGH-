<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $precio_base = $_POST['precio_base'];

    try {
        $db = Database::getInstance();

        // Verificar si el número ya existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM habitaciones WHERE numero = :numero");
        $stmt->execute(['numero' => $numero]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            throw new Exception("El número de habitación ya existe.");
        }

        // Insertar la nueva habitación
        $stmt = $db->prepare("INSERT INTO habitaciones (numero, tipo, precio_base) VALUES (:numero, :tipo, :precio_base)");
        $stmt->execute(['numero' => $numero, 'tipo' => $tipo, 'precio_base' => $precio_base]);

        header('Location: list.php');
    } catch (Exception $e) {
        echo "Error al añadir la habitación: " . $e->getMessage();
    }
}
?>