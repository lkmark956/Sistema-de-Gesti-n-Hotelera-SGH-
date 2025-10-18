<?php
require_once __DIR__ . '/../../config/database.php';

try {
    $db = Database::getInstance();
    $tasks = $db->query("SELECT t.id, t.habitacion_id, t.descripcion, t.estado, t.fecha_inicio, t.fecha_fin FROM tareas_mantenimiento t")->fetchAll();
} catch (Exception $e) {
    echo "<div class='error'>Error al cargar las tareas: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas de Mantenimiento</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout rooms-page">
    <header class="header">
        <h1>🔧 Tareas de Mantenimiento</h1>
        <nav class="navbar">
            <a href="../../../index.php">Inicio</a>
            <a href="../rooms/list.php">Habitaciones</a>
            <a href="../guests/guestsList.php">Huéspedes</a>
            <a href="../reservations/reservationsList.php">Reservas</a>
        </nav>
    </header>
    <main class="main">
        <section class="rooms">
            <h2>Lista de Tareas</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['id']) ?></td>
                                <td><?= htmlspecialchars($task['habitacion_id']) ?></td>
                                <td><?= htmlspecialchars($task['descripcion']) ?></td>
                                <td><?= htmlspecialchars($task['estado']) ?></td>
                                <td><?= htmlspecialchars($task['fecha_inicio']) ?></td>
                                <td><?= htmlspecialchars($task['fecha_fin']) ?></td>
                                <td class="actions">
                                    <form method="GET" action="editTask.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
                                    <form method="POST" action="deleteTask.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No hay tareas registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <div class="create-room">
            <form method="GET" action="addTask.php">
                <button type="submit" class="btn btn-primary">Añadir Tarea</button>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Mantenimiento</p>
    </footer>
</body>
</html>