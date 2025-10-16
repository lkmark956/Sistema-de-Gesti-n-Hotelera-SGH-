<?php
class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $cfg = require __DIR__ . '/database.php';
            $dsn = "{$cfg['driver']}:host={$cfg['host']};dbname={$cfg['database']};charset={$cfg['charset']}";
            self::$instance = new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$instance;
    }

    private function __construct() {}
}