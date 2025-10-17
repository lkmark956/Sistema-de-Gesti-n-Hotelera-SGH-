<?php
require_once __DIR__ . '/../config/database.php';

class updateReservation {
    public static function update(int $id, int $huesped_id, int $habitacion_id, string $fecha_llegada, string $fecha_salida): bool {
        try {
            $db = Database::getInstance();

            // Obtener el precio de la habitación
            $stmt = $db->prepare("SELECT precio_base FROM habitaciones WHERE id = :habitacion_id");
            $stmt->execute(['habitacion_id' => $habitacion_id]);
            $precio_base = $stmt->fetchColumn();

            // Calcular la cantidad de días de la reserva
            $dias = (strtotime($fecha_salida) - strtotime($fecha_llegada)) / (60 * 60 * 24);
            $precio_total = $precio_base * $dias;

            // Actualizar la reserva
            $stmt = $db->prepare("UPDATE reservas SET huesped_id = :huesped_id, habitacion_id = :habitacion_id, fecha_llegada = :fecha_llegada, fecha_salida = :fecha_salida, precio_total = :precio_total WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'huesped_id' => $huesped_id,
                'habitacion_id' => $habitacion_id,
                'fecha_llegada' => $fecha_llegada,
                'fecha_salida' => $fecha_salida,
                'precio_total' => $precio_total
            ]);

            return true;
        } catch (Exception $e) {
            echo "Error al actualizar la reserva: " . $e->getMessage();
            return false;
        }
    }
}
?>