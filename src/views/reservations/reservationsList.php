<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Reservation.php';

$reservations = Reservation::getAll();
if ($reservations === null) {
    $reservations = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - El Gran Descanso</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout reservations-page">
    <header class="header">
        <h1>📅 Reservas</h1>
        <nav class="navbar">
            <a href="../../../index.php">Inicio</a>
            <a href="../rooms/list.php">Habitaciones</a>
            <a href="../guests/guestsList.php">Huéspedes</a>
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
                        <th>Huésped</th>
                        <th>Habitación</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['id']) ?></td>
                        <td><?= htmlspecialchars($reservation['guest_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['room_number']) ?></td>
                        <td><?= htmlspecialchars($reservation['fecha_llegada']) ?></td>
                        <td><?= htmlspecialchars($reservation['fecha_salida']) ?></td>
                        <td>
                            <form method="POST" action="../../services/deleteReservation.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <form method="GET" action="editReservation.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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