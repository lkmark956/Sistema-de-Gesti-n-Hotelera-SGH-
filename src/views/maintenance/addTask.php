<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitacion_id = $_POST['habitacion_id'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO tareas_mantenimiento (habitacion_id, descripcion, estado, fecha_inicio, fecha_fin) VALUES (?, ?, 'Pendiente', ?, ?)");
        $stmt->execute([$habitacion_id, $descripcion, $fecha_inicio, $fecha_fin]);
        header('Location: tasks.php');
        exit();
    } catch (Exception $e) {
        echo "<div class='error'>Error al añadir la tarea: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Tarea</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout maintenance-page">
    <header class="header">
        <h1>🔧 Añadir Tarea de Mantenimiento</h1>
    </header>
    <main class="main">
        <form method="POST" action="addTask.php" class="form-room">
            <table class="form-room-table">
                <tr>
                    <td><label for="habitacion_id">ID Habitación:</label></td>
                    <td><input type="number" id="habitacion_id" name="habitacion_id" required></td>
                </tr>
                <tr>
                    <td><label for="descripcion">Descripción:</label></td>
                    <td><input type="text" id="descripcion" name="descripcion" required></td>
                </tr>
                <tr>
                    <td><label for="fecha_inicio">Fecha de Inicio:</label></td>
                    <td><input type="date" id="fecha_inicio" name="fecha_inicio" required></td>
                </tr>
                <tr>
                    <td><label for="fecha_fin">Fecha de Fin:</label></td>
                    <td><input type="date" id="fecha_fin" name="fecha_fin" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                    </td>
                </tr>
            </table>
        </form>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Mantenimiento</p>
    </footer>
</body>
</html>