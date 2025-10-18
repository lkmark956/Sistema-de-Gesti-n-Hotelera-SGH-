<?php
require_once __DIR__ . '/../../config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Huéspedes - El Gran Descanso</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout guests-page">
    <header class="header">
        <h1>👥 Huéspedes</h1>
        <nav class="navbar">
            <a href="../../../index.php">Inicio</a>
            <a href="../rooms/list.php">Habitaciones</a>
            <a href="../services/reservationsList.php">Reservas</a>
            <a href="../maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>
    <main class="main">
        <section class="guests">
            <h2>Lista de Huéspedes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Acciones</th>
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
                                    <form method="POST" action="deleteGuest.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($huesped['id']) ?>">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                    <form method="GET" action="editGuest.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($huesped['id']) ?>">
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
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
        <div class="create-guest">
            <form method="GET" action="addGuest.php">
                <button type="submit" class="btn btn-primary">Crear Nuevo Huésped</button>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>