<?php
require_once __DIR__ . '/../../config/database.php';

echo "<h2>Lista de Tareas de Mantenimiento</h2>";
echo "<p>Aquí se mostraría la lista de tareas de mantenimiento asignadas a las habitaciones.</p>";

try {
    $db = Database::getInstance();

    // Consulta para obtener las tareas de mantenimiento
    $query = $db->query("SELECT t.id, h.numero AS habitacion, t.descripcion, t.fecha_inicio, t.fecha_fin, t.estado
                         FROM tareas_mantenimiento t
                         JOIN habitaciones h ON t.habitacion_id = h.id");
    $tareas = $query->fetchAll();

    // Mostrar las tareas en una tabla
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Habitación</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado</th></tr>";
    foreach ($tareas as $tarea) {
        echo "<tr>
                <td>{$tarea['id']}</td>
                <td>{$tarea['habitacion']}</td>
                <td>{$tarea['descripcion']}</td>
                <td>{$tarea['fecha_inicio']}</td>
                <td>{$tarea['fecha_fin']}</td>
                <td>{$tarea['estado']}</td>
              </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al cargar las tareas de mantenimiento: " . $e->getMessage();
}
?>

<form method="POST" action="addTask.php">
    <h3>Añadir Tarea de Mantenimiento</h3>
    <label for="habitacion_id">ID Habitación:</label>
    <input type="number" id="habitacion_id" name="habitacion_id" required>
    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" required>
    <label for="fecha_inicio">Fecha de Inicio:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" required>
    <label for="fecha_fin">Fecha de Fin:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" required>
    <button type="submit">Añadir</button>
</form>