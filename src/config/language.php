<?php
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
        'footer' => '🌱 El Gran Descanso - Conectando con la naturaleza',
        'home' => 'Inicio',
        'rooms_list' => 'Lista de Habitaciones',
        'guests_list' => 'Lista de Huéspedes',
        'reservations_list' => 'Lista de Reservas',
        'tasks_list' => 'Lista de Tareas',
        'id' => 'ID',
        'number' => 'Número',
        'type' => 'Tipo',
        'base_price' => 'Precio Base',
        'cleaning_status' => 'Estado Limpieza',
        'actions' => 'Acciones',
        'delete' => 'Eliminar',
        'edit' => 'Editar',
        'create_room' => 'Crear Nueva Habitación',
        'name' => 'Nombre',
        'lastname' => 'Apellido',
        'email' => 'Email',
        'create_guest' => 'Crear Nuevo Huésped',
        'guest' => 'Huésped',
        'room' => 'Habitación',
        'check_in' => 'Fecha Entrada',
        'check_out' => 'Fecha Salida',
        'create_reservation' => 'Crear Nueva Reserva',
        'description' => 'Descripción',
        'status' => 'Estado',
        'start_date' => 'Fecha Inicio',
        'end_date' => 'Fecha Fin',
        'add_task' => 'Añadir Tarea',
        'maintenance_tasks' => 'Tareas de Mantenimiento'
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
        'footer' => '🌱 El Gran Descanso - Connecting with nature',
        'home' => 'Home',
        'rooms_list' => 'Rooms List',
        'guests_list' => 'Guests List',
        'reservations_list' => 'Reservations List',
        'tasks_list' => 'Tasks List',
        'id' => 'ID',
        'number' => 'Number',
        'type' => 'Type',
        'base_price' => 'Base Price',
        'cleaning_status' => 'Cleaning Status',
        'actions' => 'Actions',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'create_room' => 'Create New Room',
        'name' => 'Name',
        'lastname' => 'Last Name',
        'email' => 'Email',
        'create_guest' => 'Create New Guest',
        'guest' => 'Guest',
        'room' => 'Room',
        'check_in' => 'Check-in Date',
        'check_out' => 'Check-out Date',
        'create_reservation' => 'Create New Reservation',
        'description' => 'Description',
        'status' => 'Status',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'add_task' => 'Add Task',
        'maintenance_tasks' => 'Maintenance Tasks'
    ]
];

$t = $translations[$lang];
