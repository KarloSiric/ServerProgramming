<?php 
/**
 * @file create.php
 * @brief Event creation form view
 * 
 * Admin form for creating new events.
 * Includes all event details and venue selection.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by EventController::create()
 * @see EventController::create()
 * @see EventController::store() Processes this form
 * 
 * @var array $venues Available venues from AppModel (via header.php)
 */

// Use venues from AppModel that's already available from header
$allVenues = $venues;
?>

<div class="main-content">
    <!-- Page Header Card -->
    <div class="card admin-card">
        <div class="card-header">
            <h2>Create New Event</h2>
        </div>
        <div class="card-body">
            <!-- Back to Events List -->
            <a href="<?= PROJECT_URL; ?>/Index.php?admin/events" class="btn btn-outline">Back to Events</a>
        </div>
    </div>

    <?php 
    /**
     * Error message display
     * Shows if validation failed (future implementation)
     */
    if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php 
    /**
     * Success message display
     * Shows after successful creation (redirects usually prevent this)
     */
    if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Event Creation Form -->
    <div class="card">
        <div class="card-header">
            <h3>Event Details</h3>
        </div>
        <div class="card-body">
            <!-- Form submits to EventController::store() -->
            <form method="post" action="<?= PROJECT_URL; ?>/Index.php?event/store">
                
                <!-- Event Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control" 
                           placeholder="Event name" 
                           required>
                </div>

                <!-- Event Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" 
                              name="description" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Event description" 
                              required></textarea>
                </div>

                <!-- Two Column Layout for Date/Time -->
                <div class="grid grid-2">
                    <!-- Event Date -->
                    <div class="form-group">
                        <label for="date" class="form-label">Event Date</label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               class="form-control" 
                               min="<?= date('Y-m-d') ?>" 
                               required>
                    </div>

                    <!-- Start Time -->
                    <div class="form-group">
                        <label for="time" class="form-label">Start Time</label>
                        <input type="time" 
                               id="time" 
                               name="time" 
                               class="form-control" 
                               required>
                    </div>
                </div>

                <!-- Two Column Layout for End Time and Type -->
                <div class="grid grid-2">
                    <!-- End Time -->
                    <div class="form-group">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" 
                               id="end_time" 
                               name="end_time" 
                               class="form-control" 
                               required>
                    </div>

                    <!-- Event Type -->
                    <div class="form-group">
                        <label for="type" class="form-label">Event Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="">Select type...</option>
                            <option value="conference">Conference</option>
                            <option value="workshop">Workshop</option>
                            <option value="networking">Networking</option>
                            <option value="seminar">Seminar</option>
                            <option value="webinar">Webinar</option>
                        </select>
                    </div>
                </div>

                <!-- Venue Selection -->
                <div class="form-group">
                    <label for="venue_id" class="form-label">Venue</label>
                    <select id="venue_id" name="venue_id" class="form-control" required>
                        <option value="">Select venue...</option>
                        <?php 
                        /**
                         * Populate venue dropdown
                         * Shows venue name and capacity for context
                         */
                        foreach ($allVenues as $venue): ?>
                            <option value="<?= $venue['venue_id'] ?>">
                                <?= htmlspecialchars($venue['name']) ?> 
                                (Capacity: <?= number_format($venue['capacity']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Two Column Layout for Numbers -->
                <div class="grid grid-2">
                    <!-- Maximum Attendees -->
                    <div class="form-group">
                        <label for="allowed_number" class="form-label">Maximum Attendees</label>
                        <input type="number" 
                               id="allowed_number" 
                               name="allowed_number" 
                               class="form-control" 
                               min="1" 
                               max="10000" 
                               required>
                    </div>

                    <!-- Event Price -->
                    <div class="form-group">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               class="form-control" 
                               min="0" 
                               step="0.01" 
                               placeholder="0 for free" 
                               required>
                    </div>
                </div>

                <!-- Event Organizer -->
                <div class="form-group">
                    <label for="organizer" class="form-label">Organizer</label>
                    <input type="text" 
                           id="organizer" 
                           name="organizer" 
                           class="form-control" 
                           placeholder="Organization name" 
                           required>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Event</button>
                    <a href="<?= PROJECT_URL; ?>/Index.php?admin/events" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
