<?php
// list view; event rows include venue name (manual join)
$title = 'Admin · Events';

$eventsJoined = [];
foreach ($events as $e) {
  $venue = array_values(array_filter($venues, fn($v)=>$v['venue_id'] === $e['venue_id']))[0];
  $eventsJoined[] = $e + ['venue_name' => $venue['name']];
}
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 m-0">Manage Events</h2>
  <a class="btn btn-primary" href="<?php echo PROJECT_URL; ?>/Index.php?admin/eventedit">Add Event</a>
</div>

<table class="table table-dark table-hover align-middle">
  <thead><tr><th>Name</th><th>Start</th><th>End</th><th>Venue</th><th>Allowed</th><th class="text-end">Actions</th></tr></thead>
  <tbody>
    <?php foreach ($eventsJoined as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['name']) ?></td>
        <td><?= htmlspecialchars($e['start_date']) ?></td>
        <td><?= htmlspecialchars($e['end_date']) ?></td>
        <td><?= htmlspecialchars($e['venue_name']) ?></td>
        <td><?= (int)$e['allowed_number'] ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-secondary" href="<?php echo PROJECT_URL; ?>/Index.php?admin/eventedit&id=<?= (int)$e['event_id'] ?>">Edit</a>
          <button class="btn btn-sm btn-outline-danger" disabled>Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
