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