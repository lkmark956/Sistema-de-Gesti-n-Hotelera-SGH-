
<?php
session_start();
require_once __DIR__ . '/src/config/database.php';

// Permitir acceso solo si es admin o marco
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario'], ['admin', 'marco'])) {
    header('Location: login.php');
    exit;
}

// Manejo de idioma con cookies
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    setcookie('language', $lang, time() + (86400 * 30), "/"); // Cookie válida por 30 días
    $_COOKIE['language'] = $lang;
}

$lang = $_COOKIE['language'] ?? 'es'; // Por defecto español

// Traducciones
$translations = [
    'es' => [
        'title' => 'El Gran Descanso - Gestión Hotelera',
        'header' => '🌿 El Gran Descanso',
        'rooms' => 'Habitaciones',
        'guests' => 'Huéspedes',
        'reservations' => 'Reservas',
        'maintenance' => 'Mantenimiento',
        'logout' => 'Cerrar sesión',
        'statistics' => 'Estadísticas',
        'tasks_in_progress' => 'Tareas en curso',
        'total_reservations' => 'Total de reservas',
        'total_guests' => 'Total de huéspedes',
        'footer' => '🌱 El Gran Descanso - Conectando con la naturaleza'
    ],
    'en' => [
        'title' => 'El Gran Descanso - Hotel Management',
        'header' => '🌿 El Gran Descanso',
        'rooms' => 'Rooms',
        'guests' => 'Guests',
        'reservations' => 'Reservations',
        'maintenance' => 'Maintenance',
        'logout' => 'Logout',
        'statistics' => 'Statistics',
        'tasks_in_progress' => 'Tasks in progress',
        'total_reservations' => 'Total reservations',
        'total_guests' => 'Total guests',
        'footer' => '🌱 El Gran Descanso - Connecting with nature'
    ]
];

$t = $translations[$lang];

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
    <title><?= $t['title'] ?></title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body class="layout">
    <header class="header">
        <h1><?= $t['header'] ?></h1>
        <nav class="navbar">
            <a href="src/views/rooms/list.php"><?= $t['rooms'] ?></a>
            <a href="src/views/guests/guestsList.php"><?= $t['guests'] ?></a>
            <a href="src/views/reservations/reservationsList.php"><?= $t['reservations'] ?></a>
            <a href="src/views/maintenance/tasks.php"><?= $t['maintenance'] ?></a>
            <div class="dropdown">
                <button class="btn" id="langBtn">
                    <?php if ($lang === 'es'): ?>
                        <span style="color:#d32f2f;font-weight:bold;">ES</span>
                    <?php else: ?>
                        <span style="color:#1565c0;font-weight:bold;">GB</span>
                    <?php endif; ?>
                </button>
                <div class="dropdown-content" id="langMenu">
                    <a href="?lang=es" class="lang-es">ES</a>
                    <a href="?lang=en" class="lang-gb">GB</a>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger" style="float:right; margin-left:10px;"><?= $t['logout'] ?></a>
            <script>
                const langBtn = document.getElementById('langBtn');
                const langMenu = document.getElementById('langMenu');
                langBtn.onclick = function(e) {
                    e.preventDefault();
                    langMenu.style.display = (langMenu.style.display === 'block') ? 'none' : 'block';
                };
                document.addEventListener('click', function(e) {
                    if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                        langMenu.style.display = 'none';
                    }
                });
            </script>
        </nav>
    </header>
    <main class="main">
        <section class="stats">
            <h2><?= $t['statistics'] ?></h2>
            <div class="card-container">
                <div class="card">
                    <h3><?= $t['tasks_in_progress'] ?></h3>
                    <p><?= $tareasEnCurso ?></p>
                </div>
                <div class="card">
                    <h3><?= $t['total_reservations'] ?></h3>
                    <p><?= $totalReservas ?></p>
                </div>
                <div class="card">
                    <h3><?= $t['total_guests'] ?></h3>
                    <p><?= $totalHuespedes ?></p>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p><?= $t['footer'] ?></p>
    </footer>
</body>
</html>


