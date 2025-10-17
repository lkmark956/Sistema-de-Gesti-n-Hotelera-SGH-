<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM habitaciones WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $habitacion = $stmt->fetch();

    echo "<form method='POST' action='updateRoom.php'>
            <input type='hidden' name='id' value='{$habitacion['id']}'>
            <label for='numero'>Número:</label>
            <input type='text' id='numero' name='numero' value='{$habitacion['numero']}' required>
            <label for='tipo'>Tipo:</label>
            <input type='text' id='tipo' name='tipo' value='{$habitacion['tipo']}' required>
            <label for='precio_base'>Precio Base:</label>
            <input type='number' id='precio_base' name='precio_base' value='{$habitacion['precio_base']}' step='0.01' required>
            <button type='submit'>Actualizar</button>
          </form>";
}
?>