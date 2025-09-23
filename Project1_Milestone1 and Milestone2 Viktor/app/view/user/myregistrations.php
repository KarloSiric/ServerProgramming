<?php
// attendee’s personal list built from demo arrays
$title = 'My Registrations';
require 'app/view/inc/flash.php';

$myEvents = [];
foreach ($registrations as $r) {
  $e  = array_values(array_filter($events, fn($x)=>$x['event_id'] === $r['event_id']))[0];
  $v  = array_values(array_filter($venues, fn($x)=>$x['venue_id'] === $e['venue_id']))[0];
  $myEvents[] = ['event_id'=>$e['event_id'],'name'=>$e['name'],'start_date'=>$e['start_date'],'venue_name'=>$v['name'],'paid'=>$r['paid']];
}
?>
<h2 class="h4 mb-3">My Registrations</h2>
<?php if (empty($myEvents)): ?>
  <div class="alert alert-info">No registrations yet.</div>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($myEvents as $e): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <a href="<?php echo PROJECT_URL; ?>/Index.php?event/show&id=<?= (int)$e['event_id'] ?>" class="fw-semibold link-brand">
            <?= htmlspecialchars($e['name']) ?>
          </a>
          <div class="small text-secondary"><?= htmlspecialchars($e['start_date']) ?> — <?= htmlspecialchars($e['venue_name']) ?></div>
          <?php if ($e['paid']): ?><span class="badge bg-success mt-1">Paid</span><?php endif; ?>
        </div>
        <button class="btn btn-outline-danger btn-sm" disabled>Unregister</button>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
