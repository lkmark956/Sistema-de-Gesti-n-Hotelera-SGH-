<?php
<?php
require_once __DIR__ . '/../config/Database.php';

class Guest {
    public $id;
    public $nombre;
    public $email;
    public $documento_identidad;

    public static function findByEmail(string $email): ?self {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM guests WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $g = new self();
        foreach ($row as $k => $v) $g->$k = $v;
        return $g;
    }

    public static function create (array $data): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('INSERT INTO guests (nombre, email, documento_identidad) VALUES (:nombre, :email, :doc)');
        $stmt->execute([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'doc' => $data['documento_identidad']
        ]);
        return (int)$pdo->lastInsertId();
    }
}