<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    try {
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
                <label for='estado_limpieza'>Estado de Limpieza:</label>
                <select id='estado_limpieza' name='estado_limpieza' required>
                    <option value='Limpia' " . ($habitacion['estado_limpieza'] === 'Limpia' ? 'selected' : '') . ">Limpia</option>
                    <option value='Sucia' " . ($habitacion['estado_limpieza'] === 'Sucia' ? 'selected' : '') . ">Sucia</option>
                    <option value='En Limpieza' " . ($habitacion['estado_limpieza'] === 'En Limpieza' ? 'selected' : '') . ">En Limpieza</option>
                </select>
                <button type='submit'>Actualizar</button>
              </form>";
    } catch (Exception $e) {
        echo "Error al cargar los datos de la habitación: " . $e->getMessage();
    }
}
?>