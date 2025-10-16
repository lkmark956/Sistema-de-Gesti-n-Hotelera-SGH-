<?php
<?php
require_once __DIR__ . '/../config/Database.php';

class MaintenanceTask {
    public $id;
    public $room_id;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $estado;

    // Cuenta tareas activas que se solapan con el rango [from, to)
    public static function countActiveOverlap(int $roomId, string $from, string $to): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM maintenance_tasks
            WHERE room_id = :room_id
              AND estado <> 'Finalizada'
              AND NOT (fecha_fin <= :from OR fecha_inicio >= :to)
        ");
        $stmt->execute([':room_id' => $roomId, ':from' => $from, ':to' => $to]);
        return (int)$stmt->fetchColumn();
    }
}