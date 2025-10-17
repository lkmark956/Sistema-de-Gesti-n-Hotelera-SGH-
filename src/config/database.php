<?php
if (!class_exists('Database')) {
    class Database {
        private static ?PDO $instance = null;

        public static function getInstance(): PDO {
            if (self::$instance === null) {
                // Cargar configuración
                $cfg = require __DIR__ . '/config.php';

                // Validar que $cfg sea un array válido
                if (!is_array($cfg) || !isset($cfg['driver'], $cfg['host'], $cfg['database'], $cfg['username'], $cfg['password'], $cfg['charset'])) {
                    throw new RuntimeException('La configuración de la base de datos es inválida.');
                }

                // Crear conexión PDO
                $dsn = "{$cfg['driver']}:host={$cfg['host']};dbname={$cfg['database']};charset={$cfg['charset']}";
                try {
                    self::$instance = new PDO($dsn, $cfg['username'], $cfg['password'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                } catch (PDOException $e) {
                    throw new RuntimeException('Error al conectar con la base de datos: ' . $e->getMessage());
                }
            }
            return self::$instance;
        }

        private function __construct() {}
    }
}