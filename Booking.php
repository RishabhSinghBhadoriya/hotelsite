<?php
class Booking {
    private $db;
    private $table = 'bookings';

    public function __construct($db) {
        $this->db = $db;
    }

    public function createBooking($user_id, $room_type, $check_in, $check_out, $guests) {
        $sql = "INSERT INTO $this->table (user_id, room_type, check_in, check_out, guests) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $room_type, $check_in, $check_out, $guests]);
    }
}