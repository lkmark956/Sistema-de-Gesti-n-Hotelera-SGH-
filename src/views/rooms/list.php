<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Room.php';

$rooms = Room::all();

?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Habitaciones - El Gran Descanso</title>
    <link rel='stylesheet' href='../../style.css'>
</head>
<body class='layout rooms-page'>
    <header class='header'>
        <h1>🌿 Habitaciones</h1>
        <nav class="navbar">
            <a href="../../../index.php">Inicio</a>
            <a href="../guests/guestsList.php">Huéspedes</a>    
            <a href="../../services/reservationsList.php">Reservas</a>
            <a href="../maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>
    <main class='main'>
        <section class='rooms'>
            <h2>Lista de Habitaciones</h2>
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Precio Base</th>
                        <th>Estado Limpieza</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?= htmlspecialchars($room['id']) ?></td>
                            <td><?= htmlspecialchars($room['numero']) ?></td>
                            <td><?= htmlspecialchars($room['tipo']) ?></td>
                            <td><?= htmlspecialchars($room['precio_base']) ?></td>
                            <td><?= htmlspecialchars($room['estado_limpieza']) ?></td>
                            <td>
                                <form method="POST" action="deleteRoom.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']) ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                                <form method="GET" action="editRoom.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']) ?>">
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <div class="create-room">
            <form method="GET" action="../../views/rooms/addRoom.php">
                <button type="submit" class="btn btn-primary">Crear Nueva Habitación</button>
            </form>
        </div>
    </main>
    <footer class='footer'>
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>