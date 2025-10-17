<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM tareas_mantenimiento WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $tarea = $stmt->fetch();

        echo "<form method='POST' action='updateTask.php'>
                <input type='hidden' name='id' value='{$tarea['id']}'>
                <label for='habitacion_id'>Número de Habitación:</label>
                <input type='number' id='habitacion_id' name='habitacion_id' value='{$tarea['habitacion_id']}' required>
                <label for='descripcion'>Descripción:</label>
                <input type='text' id='descripcion' name='descripcion' value='{$tarea['descripcion']}' required>
                <label for='estado'>Estado:</label>
                <select id='estado' name='estado' required>
                    <option value='Programada' " . ($tarea['estado'] === 'Programada' ? 'selected' : '') . ">Programada</option>
                    <option value='En Curso' " . ($tarea['estado'] === 'En Curso' ? 'selected' : '') . ">En Curso</option>
                    <option value='Finalizada' " . ($tarea['estado'] === 'Finalizada' ? 'selected' : '') . ">Finalizada</option>
                </select>
                <button type='submit'>Actualizar</button>
              </form>";
    } catch (Exception $e) {
        echo "Error al cargar los datos de la tarea: " . $e->getMessage();
    }
}
?>