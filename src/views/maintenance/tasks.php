<?php
require_once __DIR__ . '/../../config/database.php';

echo "<h2>Lista de Tareas de Mantenimiento</h2>";

try {
    $db = Database::getInstance();
    $query = $db->query("SELECT * FROM tareas_mantenimiento");
    $tareas = $query->fetchAll();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Habitación</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado</th><th>Acciones</th></tr>";
    foreach ($tareas as $tarea) {
        echo "<tr>
                <td>{$tarea['id']}</td>
                <td>{$tarea['habitacion_id']}</td>
                <td>{$tarea['descripcion']}</td>
                <td>{$tarea['fecha_inicio']}</td>
                <td>{$tarea['fecha_fin']}</td>
                <td>{$tarea['estado']}</td>
                <td>
                    <form method='POST' action='deleteTask.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$tarea['id']}'>
                        <button type='submit'>Eliminar</button>
                    </form>
                    <form method='GET' action='editTask.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$tarea['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
                </td>
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