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
    public static function countActiveOverlap(int $roomId, string $startDate, string $endDate): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM tareas_mantenimiento WHERE habitacion_id = :roomId AND estado = "En Curso" AND (fecha_inicio <= :endDate AND fecha_fin >= :startDate)');
        $stmt->execute(['roomId' => $roomId, 'startDate' => $startDate, 'endDate' => $endDate]);
        return (int) $stmt->fetchColumn();
    }
}