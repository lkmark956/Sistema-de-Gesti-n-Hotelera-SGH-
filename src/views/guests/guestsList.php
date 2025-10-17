<?php
require_once __DIR__ . '/../../config/database.php';

echo "<h2>Lista de Huéspedes</h2>";

try {
    $db = Database::getInstance();
    $query = $db->query("SELECT * FROM huespedes");
    $huespedes = $query->fetchAll();

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Acciones</th></tr>";
    foreach ($huespedes as $huesped) {
        echo "<tr>
                <td>{$huesped['id']}</td>
                <td>{$huesped['nombre']}</td>
                <td>{$huesped['apellido']}</td>
                <td>{$huesped['email']}</td>
                <td>
                    <form method='POST' action='deleteGuest.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$huesped['id']}'>
                        <button type='submit'>Eliminar</button>
                    </form>
                    <form method='GET' action='editGuest.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$huesped['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al cargar los huéspedes: " . $e->getMessage();
}
?>

<form method="POST" action="addGuest.php">
    <h3>Añadir Huésped</h3>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Añadir</button>
</form>