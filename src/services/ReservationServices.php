<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Room.php';
require_once __DIR__ . '/../models/MaintenanceTask.php';

class ReservationService {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    private function nights(string $from, string $to): int {
        $d1 = new DateTime($from);
        $d2 = new DateTime($to);
        return (int)$d1->diff($d2)->format('%a');
    }

    public function crearReserva (int $guestId, int $roomId, string $fechaLlegada,  string $fechaSalida, string $estado = 'Pendiente'): int {
        if (new DateTime($fechaSalida) <= new DateTime($fechaLlegada)) {
            throw new InvalidArgumentException('La fecha de salida debe ser posterior a la de llegada.');
        }

        try {
            $this->pdo->beginTransaction();

            if (MaintenanceTask::countActiveOverlap($roomId, $fechaLlegada, $fechaSalida) > 0) {
                throw new RuntimeException('No se puede reservar: la habitación tiene tareas de mantenimiento activas en esas fechas.');
            }

                        $stmt = $this->pdo->prepare("
                                SELECT COUNT(*) FROM reservas
                                WHERE habitacion_id = :room_id
                                    AND estado = 'Confirmada'
                                    AND NOT (fecha_salida <= :from OR fecha_llegada >= :to)
                        ");

                         $stmt->execute([':room_id' => $roomId, ':from' => $fechaLlegada, ':to' => $fechaSalida]);
            if ((int)$stmt->fetchColumn() > 0) {
                $this->pdo->rollBack();
                throw new RuntimeException('La habitación ya está reservada (Confirmada) en esas fechas.');
            }

            $stmt = $this->pdo->prepare("SELECT precio_base FROM habitaciones WHERE id = :id FOR UPDATE");
            $stmt->execute([':id' => $roomId]);
            $precioBase = $stmt->fetchColumn();
            if ($precioBase === false) {
                $this->pdo->rollBack();
                throw new RuntimeException('Habitación no encontrada.');
            }

            $numNoches = $this->nights($fechaLlegada, $fechaSalida);
            $precioTotal = bcmul((string)$precioBase, (string)$numNoches, 2);

            $insert = $this->pdo->prepare("
                INSERT INTO reservas (huesped_id, habitacion_id, fecha_llegada, fecha_salida, precio_total, estado)
                VALUES (:guest_id, :room_id, :fecha_llegada, :fecha_salida, :precio_total, :estado)
            ");

            $insert->execute([
                ':guest_id' => $guestId,
                ':room_id' => $roomId,
                ':fecha_llegada' => $fechaLlegada,
                ':fecha_salida' => $fechaSalida,
                ':precio_total' => $precioTotal,
                ':estado' => $estado
            ]);

            $reservationId = (int)$this->pdo->lastInsertId();
            $this->pdo->commit();
            return $reservationId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }    
}