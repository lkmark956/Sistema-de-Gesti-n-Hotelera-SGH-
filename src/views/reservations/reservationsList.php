<?php
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - El Gran Descanso</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="layout reservations-page">
    <header class="header">
        <h1>📅 Reservas</h1>
        <nav class="navbar">
            <a href="../../../index.php">Inicio</a>
            <a href="../rooms/list.php">Habitaciones</a>
            <a href="../../services/reservationsList.php">Reservas</a>
            <a href="../maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>
    <main class="main">
        <section class="reservations">
            <h2>Lista de Reservas</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Huésped</th>
                        <th>Fecha Llegada</th>
                        <th>Fecha Salida</th>
                        <th>Precio Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $db = Database::getInstance();
                        $query = $db->query("SELECT r.id, h.numero AS habitacion, hu.nombre AS huesped, r.fecha_llegada, r.fecha_salida, r.precio_total, r.estado
                                             FROM reservas r
                                             JOIN habitaciones h ON r.habitacion_id = h.id
                                             JOIN huespedes hu ON r.huesped_id = hu.id");
                        $reservas = $query->fetchAll();
                        foreach ($reservas as $reserva): ?>
                            <tr>
                                <td><?= htmlspecialchars($reserva['id']) ?></td>
                                <td><?= htmlspecialchars($reserva['habitacion']) ?></td>
                                <td><?= htmlspecialchars($reserva['huesped']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_llegada']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_salida']) ?></td>
                                <td><?= htmlspecialchars($reserva['precio_total']) ?></td>
                                <td><?= htmlspecialchars($reserva['estado']) ?></td>
                                <td>
                                    <form method="POST" action="deleteReservation.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($reserva['id']) ?>">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                    <form method="GET" action="editReservation.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($reserva['id']) ?>">
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;
                    } catch (Exception $e) {
                        echo '<tr><td colspan="8">Error al cargar las reservas: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <div class="create-reservation">
            <form method="GET" action="addReservation.php">
                <button type="submit" class="btn btn-primary">Crear Nueva Reserva</button>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>