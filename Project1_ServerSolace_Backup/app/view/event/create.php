<?php 
$venueModel = new VenueModel();
$allVenues = $venueModel->getAllVenues();
?>

<div class="main-content">
    <div class="card admin-card">
        <div class="card-header">
            <h2>Create New Event</h2>
        </div>
        <div class="card-body">
            <a href="/event/list" class="btn btn-outline">Back to Events</a>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Event Details</h3>
        </div>
        <div class="card-body">
            <form method="post" action="/event/store">
                <div class="form-group">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           placeholder="Event name" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4" 
                              placeholder="Event description" required></textarea>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="date" class="form-label">Event Date</label>
                        <input type="date" id="date" name="date" class="form-control" 
                               min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Event Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Conference">Conference</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Networking">Networking</option>
                            <option value="Seminar">Seminar</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="venue_id" class="form-label">Venue</label>
                    <select id="venue_id" name="venue_id" class="form-control" required>
                        <option value="">Select a venue</option>
                        <?php foreach ($allVenues as $venue): ?>
                            <option value="<?= $venue['id'] ?>">
                                <?= htmlspecialchars($venue['name']) ?> 
                                (<?= number_format($venue['capacity']) ?> capacity)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success">Create Event</button>
                    <a href="/event/list" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
