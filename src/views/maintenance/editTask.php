<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM tareas_mantenimiento WHERE id = ?");
        $stmt->execute([$id]);
        $task = $stmt->fetch();
    } catch (Exception $e) {
        echo "<div class='error'>Error al cargar la tarea: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="../../style.css">
    <script src="../../theme.js"></script>
</head>
<body class="layout maintenance-page">
    <button id="theme-toggle" title="Cambiar tema">🌙</button>
    <header class="header">
        <h1>🔧 Editar Tarea de Mantenimiento</h1>
    </header>
    <main class="main">
        <form method="POST" action="updateTask.php" class="form-room">
            <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">
            <table class="form-room-table">
                <tr>
                    <td><label for="habitacion_id">ID Habitación:</label></td>
                    <td><input type="number" id="habitacion_id" name="habitacion_id" value="<?= htmlspecialchars($task['habitacion_id']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="descripcion">Descripción:</label></td>
                    <td><input type="text" id="descripcion" name="descripcion" value="<?= htmlspecialchars($task['descripcion']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="estado">Estado:</label></td>
                    <td>
                        <select id="estado" name="estado" required>
                            <option value="Pendiente" <?= $task['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="En Curso" <?= $task['estado'] == 'En Curso' ? 'selected' : '' ?>>En Curso</option>
                            <option value="Finalizada" <?= $task['estado'] == 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="fecha_inicio">Fecha de Inicio:</label></td>
                    <td><input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($task['fecha_inicio']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="fecha_fin">Fecha de Fin:</label></td>
                    <td><input type="date" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($task['fecha_fin']) ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
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