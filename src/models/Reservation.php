<?php

class Reservation {
    public $id;
    public $guest_id;
    public $room_id;
    public $check_in;
    public $check_out;
    public $status;

    public function __construct($id, $guest_id, $room_id, $check_in, $check_out, $status) {
        $this->id = $id;
        $this->guest_id = $guest_id;
        $this->room_id = $room_id;
        $this->check_in = $check_in;
        $this->check_out = $check_out;
        $this->status = $status;
    }
}