<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $precio_base = $_POST['precio_base'];
    $estado_limpieza = $_POST['estado_limpieza'];

    try {
        $db = Database::getInstance();

        // Verificar si el número ya existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM habitaciones WHERE numero = :numero");
        $stmt->execute(['numero' => $numero]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            throw new Exception("El número de habitación ya existe.");
        }

        // Insertar la nueva habitación
        $stmt = $db->prepare("INSERT INTO habitaciones (numero, tipo, precio_base, estado_limpieza) VALUES (:numero, :tipo, :precio_base, :estado_limpieza)");
        $stmt->execute(['numero' => $numero, 'tipo' => $tipo, 'precio_base' => $precio_base, 'estado_limpieza' => $estado_limpieza]);

        header('Location: list.php');
        exit;
    } catch (Exception $e) {
        echo "Error al añadir la habitación: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Habitación</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="layout">
    <header class="header">
        <h1>🌿 Crear Nueva Habitación</h1>
    </header>
    <main class="main">
        <form method="POST" action="addRoom.php" class="form-room">
            <table class="form-room-table">
                <tr>
                    <td><label for="numero">Número de Habitación:</label></td>
                    <td><input type="text" id="numero" name="numero" required></td>
                </tr>
                <tr>
                    <td><label for="tipo">Tipo de Habitación:</label></td>
                    <td><input type="text" id="tipo" name="tipo" required></td>
                </tr>
                <tr>
                    <td><label for="precio_base">Precio Base:</label></td>
                    <td><input type="number" id="precio_base" name="precio_base" step="0.01" required></td>
                </tr>
                <tr>
                    <td><label for="estado_limpieza">Estado de Limpieza:</label></td>
                    <td>
                        <select id="estado_limpieza" name="estado_limpieza" required>
                            <option value="Limpia">Limpia</option>
                            <option value="Sucia">Sucia</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Guardar Habitación</button>
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