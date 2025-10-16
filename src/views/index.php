<?php
<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Gran Descanso</title>
    <link rel="stylesheet" href="/src/styles.css">
</head>
<body class="layout">
    <header class="header">
        <h1>El Gran Descanso - Gestión Hotelera</h1>
        <nav>
            <a href="/src/views/rooms/list.php">Habitaciones</a>
            <a href="/src/views/guests/list.php">Huéspedes</a>
            <a href="/src/views/reservations/list.php">Reservas</a>
            <a href="/src/views/maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>
    <main class="container">

    <?php
    require_once __DIR__ . '/../rooms/list.php';
    ?>
    </main>
</body>
</html>
    