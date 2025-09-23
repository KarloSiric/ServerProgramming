<?php
// public list; enrich each row with venue + registered flag
$title = 'All Events';
require 'app/view/inc/flash.php';

$eventsJoined = [];
foreach ($events as $e) {
  $venue = array_values(array_filter($venues, fn($v)=>$v['venue_id'] === $e['venue_id']))[0];
  $registered = (bool)array_filter($registrations, fn($r)=>$r['event_id'] === $e['event_id']);
  $eventsJoined[] = $e + ['venue_name'=>$venue['name'], 'capacity'=>$venue['capacity'], 'registered'=>$registered];
}
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 m-0">All Events</h2>
  <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
    <a class="btn btn-outline-primary" href="<?php echo PROJECT_URL; ?>/Index.php?admin/eventedit">Add Event</a>
  <?php endif; ?>
</div>

<table class="table table-dark table-striped align-middle">
  <thead><tr>
    <th>Event</th><th>Start</th><th>End</th><th>Venue</th><th>Allowed</th><th class="text-end">Actions</th>
  </tr></thead>
  <tbody>
    <?php foreach ($eventsJoined as $e): ?>
      <tr>
        <td>
          <a class="link-brand" href="<?php echo PROJECT_URL; ?>/Index.php?event/show&id=<?= (int)$e['event_id'] ?>">
            <?= htmlspecialchars($e['name']) ?>
          </a>
        </td>
        <td><?= htmlspecialchars($e['start_date']) ?></td>
        <td><?= htmlspecialchars($e['end_date']) ?></td>
        <td><?= htmlspecialchars($e['venue_name']) ?></td>
        <td><?= (int)$e['allowed_number'] ?></td>
        <td class="text-end">
          <?php if (!empty($_SESSION['user'])): ?>
            <?php if (!empty($e['registered'])): ?>
              <button class="btn btn-sm btn-outline-danger" disabled>Unregister</button>
            <?php else: ?>
              <button class="btn btn-sm btn-primary" disabled>Register</button>
            <?php endif; ?>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
