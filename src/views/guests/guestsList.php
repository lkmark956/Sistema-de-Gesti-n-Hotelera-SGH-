<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/language.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $t['guests'] ?> - <?= $t['title'] ?></title>
    <link rel="stylesheet" href="../../style.css">
    <script src="../../theme.js"></script>
</head>
<body class="layout guests-page">
    <button id="theme-toggle" title="Cambiar tema">🌙</button>
    <header class="header">
        <h1>👥 <?= $t['guests'] ?></h1>
        <nav class="navbar">
            <a href="../../../index.php"><?= $t['home'] ?></a>
            <a href="../rooms/list.php"><?= $t['rooms'] ?></a>
            <a href="../reservations/reservationsList.php"><?= $t['reservations'] ?></a>
            <a href="../maintenance/tasks.php"><?= $t['maintenance'] ?></a>
            <a href="?lang=es" title="Español">🇪🇸</a>
            <a href="?lang=en" title="English">🇬🇧</a>
            <a href="../../../logout.php" class="btn btn-danger"><?= $t['logout'] ?></a>
        </nav>
    </header>
    <main class="main">
        <section class="guests">
            <h2><?= $t['guests_list'] ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th><?= $t['id'] ?></th>
                        <th><?= $t['name'] ?></th>
                        <th><?= $t['lastname'] ?></th>
                        <th><?= $t['email'] ?></th>
                        <th><?= $t['actions'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $db = Database::getInstance();
                        $query = $db->query("SELECT * FROM huespedes");
                        $huespedes = $query->fetchAll();
                        foreach ($huespedes as $huesped): ?>
                            <tr>
                                <td><?= htmlspecialchars($huesped['id']) ?></td>
                                <td><?= htmlspecialchars($huesped['nombre']) ?></td>
                                <td><?= htmlspecialchars($huesped['apellido']) ?></td>
                                <td><?= htmlspecialchars($huesped['email']) ?></td>
                                <td>
                                    <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
                                        <form method="POST" action="deleteGuest.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($huesped['id']) ?>">
                                            <button type="submit" class="btn btn-danger"><?= $t['delete'] ?></button>
                                        </form>
                                        <form method="GET" action="editGuest.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($huesped['id']) ?>">
                                            <button type="submit" class="btn btn-primary"><?= $t['edit'] ?></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    } catch (Exception $e) {
                        echo '<tr><td colspan="5">Error al cargar los huéspedes: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'admin'): ?>
        <div class="create-guest">
            <form method="GET" action="addGuest.php">
                <button type="submit" class="btn btn-primary"><?= $t['create_guest'] ?></button>
            </form>
        </div>
        <?php endif; ?>
    </main>
    <footer class="footer">
        <p><?= $t['footer'] ?></p>
    </footer>
</body>
</html>