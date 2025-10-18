<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido.';
    exit;
}

$id = $_POST['id'] ?? null;
if (!$id) {
    echo 'ID no especificado.';
    exit;
}

try {
    $db = Database::getInstance();
    $stmt = $db->prepare('DELETE FROM reservas WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: ../views/reservations/reservationsList.php');
    exit;
} catch (Exception $e) {
    echo '<div class="error">Error al eliminar reserva: '.htmlspecialchars($e->getMessage()).'</div>';
}
