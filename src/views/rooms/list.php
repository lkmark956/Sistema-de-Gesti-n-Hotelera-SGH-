<?php
require_once __DIR__ . '/../../models/Room.php';
require_once __DIR__ . '/../../models/MaintenanceTask.php';

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
              $maintCount = MaintenanceTask::countActiveOverlap((int)$room['id'], $today, $tomorrow);
              $maintBadge = $maintCount > 0 ? '<span class="maintenance-note">Sí</span>' : '—';
              $cleanClass = match($room['cleaning_state'] ?? 'Limpia') {
                'Limpia' => 'status-clean',
                'Sucia' => 'status-dirty',
                'En Limpieza' => 'status-cleaning',
                default => 'status-clean'
              };
            ?>
            <tr>
              <td><?= htmlspecialchars($room['numero']) ?></td>
              <td><?= htmlspecialchars($room['tipo']) ?></td>
              <td>$<?= number_format($room['precio_base'], 2) ?></td>
              <td><span class="<?= $cleanClass ?>"><?= htmlspecialchars($room['cleaning_state']) ?></span></td>
              <td><?= $maintBadge ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        </table>
    </div>
</section>