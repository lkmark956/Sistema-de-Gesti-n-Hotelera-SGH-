<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/language.php';

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
    <title><?= $t['maintenance_tasks'] ?></title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout rooms-page">
    <header class="header">
        <h1>🔧 <?= $t['maintenance_tasks'] ?></h1>
        <nav class="navbar">
            <a href="../../../index.php"><?= $t['home'] ?></a>
            <a href="../rooms/list.php"><?= $t['rooms'] ?></a>
            <a href="../guests/guestsList.php"><?= $t['guests'] ?></a>
            <a href="../reservations/reservationsList.php"><?= $t['reservations'] ?></a>
            <a href="?lang=es" title="Español">🇪🇸</a>
            <a href="?lang=en" title="English">🇬🇧</a>
            <a href="../../../logout.php" class="btn btn-danger" style="float:right;"><?= $t['logout'] ?></a>
        </nav>
    </header>
    <main class="main">
        <section class="rooms">
            <h2><?= $t['tasks_list'] ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th><?= $t['id'] ?></th>
                        <th><?= $t['room'] ?></th>
                        <th><?= $t['description'] ?></th>
                        <th><?= $t['status'] ?></th>
                        <th><?= $t['start_date'] ?></th>
                        <th><?= $t['end_date'] ?></th>
                        <th><?= $t['actions'] ?></th>
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
                                    <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
                                        <form method="GET" action="editTask.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                            <button type="submit" class="btn btn-primary"><?= $t['edit'] ?></button>
                                        </form>
                                        <form method="POST" action="deleteTask.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                            <button type="submit" class="btn btn-danger"><?= $t['delete'] ?></button>
                                        </form>
                                    <?php endif; ?>
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
        <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
        <div class="create-room">
            <form method="GET" action="addTask.php">
                <button type="submit" class="btn btn-primary"><?= $t['add_task'] ?></button>
            </form>
        </div>
        <?php endif; ?>
    </main>
    <footer class="footer">
        <p><?= $t['footer'] ?></p>
    </footer>
</body>
</html>