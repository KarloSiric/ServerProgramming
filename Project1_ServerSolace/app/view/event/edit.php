<?php
// Event edit form
$event = $event ?? null;
if (!$event) {
    header('Location: ' . PROJECT_URL . '/Index.php?admin/events');
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Event: <?= htmlspecialchars($event['name']) ?></h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= PROJECT_URL; ?>/Index.php?event/update">
                        <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Event Name</label>
                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($event['description']) ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" value="<?= $event['date'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Time</label>
                                <input type="text" class="form-control" name="time" value="<?= $event['time'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Time</label>
                                <input type="text" class="form-control" name="end_time" value="<?= $event['end_time'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="conference" <?= $event['type'] == 'conference' ? 'selected' : '' ?>>Conference</option>
                                    <option value="workshop" <?= $event['type'] == 'workshop' ? 'selected' : '' ?>>Workshop</option>
                                    <option value="networking" <?= $event['type'] == 'networking' ? 'selected' : '' ?>>Networking</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" value="<?= $event['price'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Attendees</label>
                                <input type="number" class="form-control" name="allowed_number" value="<?= $event['allowed_number'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Venue</label>
                            <select class="form-control" name="venue_id">
                                <?php foreach ($venues as $venue): ?>
                                    <option value="<?= $venue['venue_id'] ?>" <?= $event['venue_id'] == $venue['venue_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($venue['name']) ?> (Capacity: <?= $venue['capacity'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Organizer</label>
                            <input type="text" class="form-control" name="organizer" value="<?= htmlspecialchars($event['organizer']) ?>" required>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="<?= PROJECT_URL; ?>/Index.php?admin/events" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
