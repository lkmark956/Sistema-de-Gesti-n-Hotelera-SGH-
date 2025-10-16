<?php
require_once __DIR__ . '/../config/Database.php';

class Room {
    public int $id;
    public $numero;
    public $tipo;
    public $precio_base;
    public $cleaning_state;

    public static function findById(int $id): ?self {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $r = new self();
        foreach ($row as $k => $v) $r->$k = $v;
        return $r;
    }

    public static function all(): array {
        $pdo = Database::getInstance();
        return $pdo->query('SELECT * FROM rooms')->fetchAll();
    }

    public static function updateCleaningState(int $id, string $state): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('UPDATE rooms SET cleaning_state = :state WHERE id = :id');
        return $stmt->execute(['state' => $state, 'id' => $id]);
    }
}