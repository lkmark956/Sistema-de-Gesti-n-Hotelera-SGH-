<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $precio_base = $_POST['precio_base'];
    $estado_limpieza = $_POST['estado_limpieza'];

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE habitaciones SET numero = :numero, tipo = :tipo, precio_base = :precio_base, estado_limpieza = :estado_limpieza WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'numero' => $numero,
            'tipo' => $tipo,
            'precio_base' => $precio_base,
            'estado_limpieza' => $estado_limpieza
        ]);

        header('Location: list.php');
    } catch (Exception $e) {
        echo "Error al actualizar la habitación: " . $e->getMessage();
    }
}
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
        <!-- Tu formulario de edición aquí -->
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
</body>
</html>