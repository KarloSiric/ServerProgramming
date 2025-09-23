<?php
// detail page; fetch by id from query string
$title = 'Event Details';
require 'app/view/inc/flash.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$event = array_values(array_filter($events, fn($e)=>$e['event_id'] === $id))[0] ?? $events[0];
$venue = array_values(array_filter($venues, fn($v)=>$v['venue_id'] === $event['venue_id']))[0];
$registered = (bool)array_filter($registrations, fn($r)=>$r['event_id'] === $event['event_id']);
?>
<a class="btn btn-link mb-3" href="<?php echo PROJECT_URL; ?>/Index.php?event/index">&larr; Back</a>

<div class="card">
  <div class="card-body">
    <h3 class="h4 card-title"><?= htmlspecialchars($event['name']) ?></h3>
    <div class="small text-secondary mb-2">
      <strong>Start:</strong> <?= htmlspecialchars($event['start_date']) ?> —
      <strong>End:</strong> <?= htmlspecialchars($event['end_date']) ?>
    </div>
    <p class="mb-2"><strong>Venue:</strong> <?= htmlspecialchars($venue['name']) ?> (cap <?= (int)$venue['capacity'] ?>)</p>
    <p class="mb-2"><strong>Allowed number:</strong> <?= (int)$event['allowed_number'] ?></p>
    <?php if (!empty($_SESSION['user'])): ?>
      <?php if ($registered): ?>
        <button class="btn btn-outline-danger" disabled>Unregister</button>
      <?php else: ?>
        <button class="btn btn-primary" disabled>Register</button>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
