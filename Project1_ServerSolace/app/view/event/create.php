<?php 
$venueModel = new VenueModel();
$allVenues = $venueModel->getAllVenues();
$isEditing = isset($event) && !empty($event);
$pageTitle = $isEditing ? 'Edit Event' : 'Create New Event';
$buttonText = $isEditing ? 'Update Event' : 'Create Event';
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">📅</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Events</span>
            </div>
            <div>
                <a href="?admin/events" class="btn-admin btn-admin-outline">← Back to Events</a>
            </div>
        </div>
        <h1><?= $pageTitle ?></h1>
        <p><?= $isEditing ? 'Update event details' : 'Create a new event for your attendees' ?></p>
    </div>

    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger" style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; color: #721c24; margin-bottom: 20px;">
            <strong>Error:</strong> <?= htmlspecialchars($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; color: #155724; margin-bottom: 20px;">
            <strong>Success:</strong> <?= htmlspecialchars($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <div class="admin-card">
        <div style="padding: 24px;">
            <form method="POST" action="?event/store">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                <?php endif; ?>
                
                <div style="display: grid; gap: 20px;">
                    <div class="form-group">
                        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Event Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?= $isEditing ? htmlspecialchars($event['name']) : '' ?>"
                               class="form-control" 
                               style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                               placeholder="Enter event name" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Description *</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4" 
                                  class="form-control" 
                                  style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical;"
                                  placeholder="Enter event description" 
                                  required><?= $isEditing ? htmlspecialchars($event['description']) : '' ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="date" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Event Date *</label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="<?= $isEditing ? $event['date'] : '' ?>"
                                   class="form-control" 
                                   style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                                   min="<?= date('Y-m-d') ?>" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="type" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Event Type *</label>
                            <select id="type" 
                                    name="type" 
                                    class="form-control" 
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                                    required>
                                <option value="">Select Event Type</option>
                                <option value="conference" <?= ($isEditing && $event['type'] === 'conference') ? 'selected' : '' ?>>Conference</option>
                                <option value="workshop" <?= ($isEditing && $event['type'] === 'workshop') ? 'selected' : '' ?>>Workshop</option>
                                <option value="networking" <?= ($isEditing && $event['type'] === 'networking') ? 'selected' : '' ?>>Networking</option>
                                <option value="seminar" <?= ($isEditing && $event['type'] === 'seminar') ? 'selected' : '' ?>>Seminar</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Venue *</label>
                        <select id="venue_id" 
                                name="venue_id" 
                                class="form-control" 
                                style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                                required>
                            <option value="">Select a venue</option>
                            <?php foreach ($allVenues as $venue): ?>
                                <option value="<?= $venue['id'] ?>" <?= ($isEditing && $event['venue_id'] == $venue['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($venue['name']) ?> 
                                    (Capacity: <?= number_format($venue['capacity']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="time" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Start Time</label>
                            <input type="time" 
                                   id="time" 
                                   name="time" 
                                   value="09:00"
                                   class="form-control" 
                                   style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                        </div>

                        <div class="form-group">
                            <label for="price" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Price ($)</label>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="<?= $isEditing ? ($event['price'] ?? 199) : 199 ?>"
                                   min="0" 
                                   step="1"
                                   class="form-control" 
                                   style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                                   placeholder="199">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="organizer" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Organizer</label>
                        <input type="text" 
                               id="organizer" 
                               name="organizer" 
                               value="<?= $isEditing ? htmlspecialchars($event['organizer'] ?? 'Event Foundation') : 'Event Foundation' ?>"
                               class="form-control" 
                               style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                               placeholder="Event Foundation">
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <button type="submit" class="btn-admin btn-admin-primary" style="flex: 1;">
                        <span>💾</span> <?= $buttonText ?>
                    </button>
                    <a href="?admin/events" class="btn-admin btn-admin-outline" style="flex: 1; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <span>❌</span> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
