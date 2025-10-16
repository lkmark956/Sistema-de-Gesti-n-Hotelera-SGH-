<?php
// index.php (vista principal)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Gran Descanso</title>
    <!-- style.css está en src/, desde src/views la ruta relativa es ../style.css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="layout">
    <header class="header">
        <h1>El Gran Descanso - Gestión Hotelera</h1>
        <nav>
            <!-- rutas relativas dentro de views -->
            <a href="rooms/list.php">Habitaciones</a>
            <a href="guests/list.php">Huéspedes</a>
            <a href="reservations/list.php">Reservas</a>
            <a href="maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>

    <main class="container">
        <?php
        // incluir correctamente el listado: rooms está dentro de views
        require_once __DIR__ . '/rooms/list.php';
        ?>
    </main>
</body>
</html>
