<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/language.php';
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
    <title><?= $t['reservations'] ?> - <?= $t['title'] ?></title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout reservations-page">
    <header class="header">
        <h1>📅 <?= $t['reservations'] ?></h1>
        <nav class="navbar">
            <a href="../../../index.php"><?= $t['home'] ?></a>
            <a href="../rooms/list.php"><?= $t['rooms'] ?></a>
            <a href="../guests/guestsList.php"><?= $t['guests'] ?></a>
            <a href="../maintenance/tasks.php"><?= $t['maintenance'] ?></a>
            <a href="?lang=es" title="Español">🇪🇸</a>
            <a href="?lang=en" title="English">🇬🇧</a>
            <a href="../../../logout.php" class="btn btn-danger" style="float:right;"><?= $t['logout'] ?></a>
        </nav>
    </header>
    <main class="main">
        <section class="reservations">
            <h2><?= $t['reservations_list'] ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th><?= $t['id'] ?></th>
                        <th><?= $t['guest'] ?></th>
                        <th><?= $t['room'] ?></th>
                        <th><?= $t['check_in'] ?></th>
                        <th><?= $t['check_out'] ?></th>
                        <th><?= $t['actions'] ?></th>
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
                            <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
                                <form method="POST" action="../../services/deleteReservation.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
                                    <button type="submit" class="btn btn-danger"><?= $t['delete'] ?></button>
                                </form>
                                <form method="GET" action="editReservation.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
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
        <div class="create-reservation">
            <form method="GET" action="addReservation.php">
                <button type="submit" class="btn btn-primary"><?= $t['create_reservation'] ?></button>
            </form>
        </div>
        <?php endif; ?>
    </main>
    <footer class="footer">
        <p><?= $t['footer'] ?></p>
    </footer>
</body>
</html>