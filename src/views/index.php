<?php
// index.php (vista principal)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Gran Descanso</title>
    <!-- style.css está en src/, desde src/views la ruta relativa es ../style.css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="layout">
    <header class="header">
        <h1>El Gran Descanso - Gestión Hotelera</h1>
        <nav>
            <!-- rutas relativas dentro de views -->
            <a href="rooms/list.php">Habitaciones</a>
            <a href="guests/guestsList.php">Huéspedes</a>
            <a href="../services/reservationsList.php">Reservas</a>
            <a href="maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>

    
</body>
</html>

<?php
if (!class_exists('Database')) {
    class Database {
        private static ?PDO $instance = null;

        public static function getInstance(): PDO {
            if (self::$instance === null) {
                $cfg = require __DIR__ . '/database.php';

                // Validar que $cfg sea un array y contenga las claves necesarias
                if (!is_array($cfg) || !isset($cfg['driver'], $cfg['host'], $cfg['database'], $cfg['username'], $cfg['password'], $cfg['charset'])) {
                    throw new RuntimeException('La configuración de la base de datos es inválida.');
                }

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


return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'hotel_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
?>
