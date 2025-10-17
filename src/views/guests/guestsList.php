<?php
require_once __DIR__ . '/../../config/database.php';

echo "<h2>Lista de Huéspedes</h2>";
echo "<p>Aquí se mostraría la lista de huéspedes registrados en el sistema.</p>";

try {
    $db = Database::getInstance();

    $query = $db->query("SELECT id, nombre, apellido, email FROM huespedes");
    $huespedes = $query->fetchAll();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th></tr>";
    foreach ($huespedes as $huesped) {
        echo "<tr><td>{$huesped['id']}</td><td>{$huesped['nombre']}</td><td>{$huesped['apellido']}</td><td>{$huesped['email']}</td></tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al cargar los huéspedes: " . $e->getMessage();
}
?>