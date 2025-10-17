<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Room.php';
require_once __DIR__ . '/../../models/MaintenanceTask.php';

// Room::all() devuelve array; si tu Room::all() usa PDO::FETCH_ASSOC, $rooms será array de arrays
$rooms = Room::all();
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
?>

<form method="POST" action="addRoom.php">
    <h3>Añadir Habitación</h3>
    <label for="numero">Número:</label>
    <input type="text" id="numero" name="numero" required>
    <label for="tipo">Tipo:</label>
    <input type="text" id="tipo" name="tipo" required>
    <label for="precio_base">Precio Base:</label>
    <input type="number" id="precio_base" name="precio_base" step="0.01" required>
    <button type="submit">Añadir</button>
</form>

<?php
require_once __DIR__ . '/../../config/database.php';

echo "<h2>Lista de Habitaciones</h2>";

try {
    $db = Database::getInstance();
    $query = $db->query("SELECT * FROM habitaciones");
    $habitaciones = $query->fetchAll();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Número</th><th>Tipo</th><th>Precio Base</th><th>Estado Limpieza</th><th>Acciones</th></tr>";
    foreach ($habitaciones as $habitacion) {
        echo "<tr>
                <td>{$habitacion['id']}</td>
                <td>{$habitacion['numero']}</td>
                <td>{$habitacion['tipo']}</td>
                <td>{$habitacion['precio_base']}</td>
                <td>{$habitacion['estado_limpieza']}</td>
                <td>
                    <form method='POST' action='deleteRoom.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$habitacion['id']}'>
                        <button type='submit'>Eliminar</button>
                    </form>
                    <form method='GET' action='editRoom.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$habitacion['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al cargar las habitaciones: " . $e->getMessage();
}
?>