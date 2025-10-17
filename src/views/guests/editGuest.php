<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM huespedes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $huesped = $stmt->fetch();

        echo "<form method='POST' action='updateGuest.php'>
                <input type='hidden' name='id' value='{$huesped['id']}'>
                <label for='nombre'>Nombre:</label>
                <input type='text' id='nombre' name='nombre' value='{$huesped['nombre']}' required>
                <label for='apellido'>Apellido:</label>
                <input type='text' id='apellido' name='apellido' value='{$huesped['apellido']}' required>
                <label for='email'>Email:</label>
                <input type='email' id='email' name='email' value='{$huesped['email']}' required>
                <button type='submit'>Actualizar</button>
              </form>";
    } catch (Exception $e) {
        echo "Error al cargar los datos del huésped: " . $e->getMessage();
    }
}
?>