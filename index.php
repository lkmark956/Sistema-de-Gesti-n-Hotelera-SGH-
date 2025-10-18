<?php
require_once __DIR__ . '/src/config/database.php';

try {
    $db = Database::getInstance(); 

    // Contar tareas en curso
    $stmt = $db->query("SELECT COUNT(*) AS tareas_en_curso FROM tareas_mantenimiento WHERE estado = 'En Curso'");
    $tareasEnCurso = $stmt->fetchColumn();

    // Contar reservas
    $stmt = $db->query("SELECT COUNT(*) AS total_reservas FROM reservas");
    $totalReservas = $stmt->fetchColumn();

    // Contar huéspedes
    $stmt = $db->query("SELECT COUNT(*) AS total_huespedes FROM huespedes");
    $totalHuespedes = $stmt->fetchColumn();
} catch (Exception $e) {
    echo "Error al cargar las estadísticas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Gran Descanso - Gestión Hotelera</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body class="layout">
    <header class="header">
        <h1>🌿 El Gran Descanso</h1>
        <nav class="navbar">
            <a href="src/views/rooms/list.php">Habitaciones</a>
            <a href="src/views/guests/guestsList.php">Huéspedes</a>
            <a href="src/views/reservations/reservationsList.php">Reservas</a>
            <a href="src/views/maintenance/tasks.php">Mantenimiento</a>
        </nav>
    </header>
    <main class="main">
        <section class="stats">
            <h2>Estadísticas</h2>
            <div class="card-container">
                <div class="card">
                    <h3>Tareas en curso</h3>
                    <p><?= $tareasEnCurso ?></p>
                </div>
                <div class="card">
                    <h3>Total de reservas</h3>
                    <p><?= $totalReservas ?></p>
                </div>
                <div class="card">
                    <h3>Total de huéspedes</h3>
                    <p><?= $totalHuespedes ?></p>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>🌱 El Gran Descanso - Conectando con la naturaleza</p>
    </footer>
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

<style>
body {
    background: url('./img/Principal.jpg') no-repeat center center fixed; /* Imagen de fondo */
    background-size: cover;
}
</style>
