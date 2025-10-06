<?php
$isEdit = !empty($event);
$action = $isEdit
  ? (PROJECT_URL . "/event/update")
  : (PROJECT_URL . "/event/store");
?>
<section class="card" style="max-width: 800px;">
  <h2><?= $isEdit ? 'Edit Event' : 'Create Event' ?></h2>
  <form class="form" method="post" action="<?= htmlspecialchars($action) ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= (int)$event['event_id'] ?>">
    <?php endif; ?>

    <label>Event Name
      <input name="name" required value="<?= htmlspecialchars($event['name'] ?? '') ?>">
    </label>

    <label>Start Date & Time
      <input type="datetime-local" name="start_date" required
        value="<?= isset($event['start_date']) ? date('Y-m-d\TH:i', strtotime($event['start_date'])) : '' ?>">
    </label>

    <label>End Date & Time
      <input type="datetime-local" name="end_date" required
        value="<?= isset($event['end_date']) ? date('Y-m-d\TH:i', strtotime($event['end_date'])) : '' ?>">
    </label>

    <label>Allowed Number
      <input type="number" name="allowed_number" min="0" required
        value="<?= (int)($event['allowed_number'] ?? 0) ?>">
    </label>

    <label>Venue
      <select name="venue_id" required>
        <option value="" disabled <?= empty($event['venue_id']) ? 'selected' : '' ?>>Select a venue</option>
        <?php foreach ($venues as $v): ?>
          <option value="<?= (int)$v['venue_id'] ?>"
            <?= isset($event['venue_id']) && (int)$event['venue_id'] === (int)$v['venue_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($v['name']) ?> (cap <?= (int)$v['capacity'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <button><?= $isEdit ? 'Update Event' : 'Create Event' ?></button>
  </form>
  <p class="hint" style="margin-top:1rem">
    <?= $isEdit ? 'Editing existing event.' : 'Fill details and save to add a new event.' ?>
  </p>
</section>
