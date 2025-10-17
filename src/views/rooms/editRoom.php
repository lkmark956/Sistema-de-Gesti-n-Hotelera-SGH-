<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM habitaciones WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $habitacion = $stmt->fetch();

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Habitación</title>
            <link rel="stylesheet" href="../../style.css">
        </head>
        <body class="layout rooms-page">
            <header class="header">
                <h1>🌿 Editar Habitación</h1>
            </header>
            <main class="main">
                <form method="POST" action="updateRoom.php" class="form-room">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($habitacion['id']) ?>">
                    <table class="form-room-table">
                        <tr>
                            <td><label for="numero">Número de Habitación:</label></td>
                            <td><input type="text" id="numero" name="numero" value="<?= htmlspecialchars($habitacion['numero']) ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="tipo">Tipo de Habitación:</label></td>
                            <td><input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($habitacion['tipo']) ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="precio_base">Precio Base:</label></td>
                            <td><input type="number" id="precio_base" name="precio_base" value="<?= htmlspecialchars($habitacion['precio_base']) ?>" step="0.01" required></td>
                        </tr>
                        <tr>
                            <td><label for="estado_limpieza">Estado de Limpieza:</label></td>
                            <td>
                                <select id="estado_limpieza" name="estado_limpieza" required>
                                    <option value="Limpia" <?= $habitacion['estado_limpieza'] === 'Limpia' ? 'selected' : '' ?>>Limpia</option>
                                    <option value="Sucia" <?= $habitacion['estado_limpieza'] === 'Sucia' ? 'selected' : '' ?>>Sucia</option>
                                    <option value="En Limpieza" <?= $habitacion['estado_limpieza'] === 'En Limpieza' ? 'selected' : '' ?>>En Limpieza</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit">Actualizar</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </main>
            <footer class="footer">
                <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
            </footer>
        </body>
        </html>
        <?php
    } catch (Exception $e) {
        echo "Error al cargar los datos de la habitación: " . $e->getMessage();
    }
}
?>