<?php
// one form handles both add and edit depending on ?id
$title = 'Admin · Edit Event';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$event = null;

if ($id) {
  foreach ($events as $e) if ($e['event_id'] === $id) $event = $e; // quick find
}
?>
<h2 class="h4 mb-3"><?= $event ? 'Edit' : 'Add' ?> Event</h2>
<form method="post" action="#" class="row g-3" style="max-width:720px">
  <?php if ($event): ?>
    <input type="hidden" name="event_id" value="<?= (int)$event['event_id'] ?>">
  <?php endif; ?>

  <div class="col-12">
    <label class="form-label">Name</label>
    <input class="form-control" name="name" required maxlength="50" value="<?= htmlspecialchars($event['name'] ?? '') ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Start date & time</label>
    <input class="form-control" type="datetime-local" name="start_date" required
           value="<?= !empty($event['start_date']) ? date('Y-m-d\TH:i', strtotime($event['start_date'])) : '' ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">End date & time</label>
    <input class="form-control" type="datetime-local" name="end_date" required
           value="<?= !empty($event['end_date']) ? date('Y-m-d\TH:i', strtotime($event['end_date'])) : '' ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Allowed number</label>
    <input class="form-control" type="number" name="allowed_number" min="1" max="100000" required
           value="<?= htmlspecialchars($event['allowed_number'] ?? '') ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Venue</label>
    <select class="form-select" name="venue_id" required>
      <option value="">Select venue…</option>
      <?php foreach ($venues as $v): ?>
        <option value="<?= (int)$v['venue_id'] ?>" <?= (!empty($event['venue_id']) && $event['venue_id'] == $v['venue_id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($v['name']) ?> (cap <?= (int)$v['capacity'] ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary"><?= $event ? 'Save Changes' : 'Create Event' ?></button>
    <a class="btn btn-outline-secondary" href="<?php echo PROJECT_URL; ?>/Index.php?admin/events">Cancel</a>
  </div>
</form>
