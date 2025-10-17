<?php
require_once __DIR__ . '/../config/database.php';

echo "<h2>Lista de Reservas</h2>";
echo "<p>Aquí se mostraría la lista de reservas realizadas en el sistema.</p>";

try {
    $db = Database::getInstance();

    // Consulta para obtener las reservas
    $query = $db->query("SELECT r.id, h.numero AS habitacion, hu.nombre AS huesped, r.fecha_llegada, r.fecha_salida, r.precio_total, r.estado
                         FROM reservas r
                         JOIN habitaciones h ON r.habitacion_id = h.id
                         JOIN huespedes hu ON r.huesped_id = hu.id");
    $reservas = $query->fetchAll();

    // Mostrar las reservas en una tabla
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Habitación</th><th>Huésped</th><th>Fecha Llegada</th><th>Fecha Salida</th><th>Precio Total</th><th>Estado</th><th>Acciones</th></tr>";
    foreach ($reservas as $reserva) {
        echo "<tr>
                <td>{$reserva['id']}</td>
                <td>{$reserva['habitacion']}</td>
                <td>{$reserva['huesped']}</td>
                <td>{$reserva['fecha_llegada']}</td>
                <td>{$reserva['fecha_salida']}</td>
                <td>{$reserva['precio_total']}</td>
                <td>{$reserva['estado']}</td>
                <td>
                    <form method='POST' action='deleteReservation.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$reserva['id']}'>
                        <button type='submit'>Eliminar</button>
                    </form>
                    <form method='GET' action='editReservation.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$reserva['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al cargar las reservas: " . $e->getMessage();
}
?>

<form method="POST" action="addReservation.php">
    <h3>Añadir Reserva</h3>
    <label for="huesped_id">ID Huésped:</label>
    <input type="number" id="huesped_id" name="huesped_id" required>
    <label for="habitacion_id">ID Habitación:</label>
    <input type="number" id="habitacion_id" name="habitacion_id" required>
    <label for="fecha_llegada">Fecha de Llegada:</label>
    <input type="date" id="fecha_llegada" name="fecha_llegada" required>
    <label for="fecha_salida">Fecha de Salida:</label>
    <input type="date" id="fecha_salida" name="fecha_salida" required>
    <button type="submit">Añadir</button>
</form>