<?php
require_once __DIR__ . '/../../models/Room.php';
require_once __DIR__ . '/../../models/MaintenanceTask.php';

// Room::all() devuelve array; si tu Room::all() usa PDO::FETCH_ASSOC, $rooms será array de arrays
$rooms = Room::all();
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
?>
<section id="rooms" class="card">
  <div class="card-title">Habitaciones</div>
  <div class="card-body">
    <table class="table">
      <thead>
        <tr><th>Nº</th><th>Tipo</th><th>Precio</th><th>Estado limpieza</th><th>Mantenimiento hoy</th></tr>
      </thead>
      <tbody>
        <?php if (empty($rooms)): ?>
          <tr><td colspan="5">No hay habitaciones registradas.</td></tr>
        <?php else: ?>
          <?php foreach ($rooms as $room): ?>
            <?php
              $roomId = (int)($room['id'] ?? $room->id ?? 0);
              $maintCount = MaintenanceTask::countActiveOverlap($roomId, $today, $tomorrow);
              $maintBadge = $maintCount > 0 ? '<span class="maintenance-note">Sí</span>' : '—';
              $cleanState = $room['cleaning_state'] ?? ($room->cleaning_state ?? 'Limpia');
              $cleanClass = $cleanState === 'Limpia' ? 'status-clean' : ($cleanState === 'Sucia' ? 'status-dirty' : 'status-cleaning');
            ?>
            <tr>
              <td><?= htmlspecialchars($room['numero'] ?? $room->numero) ?></td>
              <td><?= htmlspecialchars($room['tipo'] ?? $room->tipo) ?></td>
              <td>$<?= number_format((float)($room['precio_base'] ?? $room->precio_base), 2) ?></td>
              <td><span class="<?= $cleanClass ?>"><?= htmlspecialchars($cleanState) ?></span></td>
              <td><?= $maintBadge ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>