<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/language.php';
require_once __DIR__ . '/../../models/Room.php';

$rooms = Room::all();

?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title><?= $t['rooms'] ?> - <?= $t['title'] ?></title>
    <link rel='stylesheet' href='../../style.css'>
</head>
<body class='layout rooms-page'>
    <header class='header'>
        <h1>🌿 <?= $t['rooms'] ?></h1>
        <nav class="navbar">
            <a href="../../../index.php"><?= $t['home'] ?></a>
            <a href="../guests/guestsList.php"><?= $t['guests'] ?></a>
            <a href="../reservations/reservationsList.php"><?= $t['reservations'] ?></a>
            <a href="../maintenance/tasks.php"><?= $t['maintenance'] ?></a>
            <a href="?lang=es" title="Español">🇪🇸</a>
            <a href="?lang=en" title="English">🇬🇧</a>
            <a href="../../../logout.php" class="btn btn-danger" style="float:right;"><?= $t['logout'] ?></a>
        </nav>
    </header>
    <main class='main'>
        <section class='rooms'>
            <h2><?= $t['rooms_list'] ?></h2>
            <table class='table'>
                <thead>
                    <tr>
                        <th><?= $t['id'] ?></th>
                        <th><?= $t['number'] ?></th>
                        <th><?= $t['type'] ?></th>
                        <th><?= $t['base_price'] ?></th>
                        <th><?= $t['cleaning_status'] ?></th>
                        <th><?= $t['actions'] ?></th>
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
                                <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
                                    <form method="POST" action="deleteRoom.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']) ?>">
                                        <button type="submit" class="btn btn-danger"><?= $t['delete'] ?></button>
                                    </form>
                                    <form method="GET" action="editRoom.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']) ?>">
                                        <button type="submit" class="btn btn-primary"><?= $t['edit'] ?></button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
        <div class="create-room">
            <form method="GET" action="../../views/rooms/addRoom.php">
                <button type="submit" class="btn btn-primary"><?= $t['create_room'] ?></button>
            </form>
        </div>
        <?php endif; ?>
    </main>
    <footer class='footer'>
        <p><?= $t['footer'] ?></p>
    </footer>
</body>
</html>