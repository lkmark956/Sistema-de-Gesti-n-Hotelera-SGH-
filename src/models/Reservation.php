<?php

class Reservation
{
    public $id;
    public $guest_id;
    public $room_id;
    public $check_in;
    public $check_out;
    public $status;

    public function __construct($id, $guest_id, $room_id, $check_in, $check_out, $status)
    {
        $this->id = $id;
        $this->guest_id = $guest_id;
        $this->room_id = $room_id;
        $this->check_in = $check_in;
        $this->check_out = $check_out;
        $this->status = $status;
    }

    public static function getAll()
    {
        require __DIR__ . '/../config/database.php';
        $db = Database::getInstance();
        $stmt = $db->query("SELECT r.id, h.nombre AS guest_name, rm.numero AS room_number, r.fecha_llegada, r.fecha_salida
                            FROM reservas r
                            JOIN huespedes h ON r.huesped_id = h.id
                            JOIN habitaciones rm ON r.habitacion_id = rm.id");
        return $stmt->fetchAll();
    }
}