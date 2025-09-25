<?php
/**
 * @file show.php
 * @brief Event details view - Shows single event with full information
 * 
 * Displays comprehensive event details including venue, time, capacity,
 * and registration options. Different actions based on user role.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by EventController::show()
 * @see EventController::show()
 * 
 * @var array|null $event Event data passed from controller
 */

// Validate event data exists
$event = $event ?? null;
if (!$event) {
    // Redirect if no event found
    header('Location: ' . PROJECT_URL . '/Index.php?user/dashboard');
    exit;
}

/**
 * Calculate event statistics
 */
$isFull = ($event['registration_count'] ?? 0) >= $event['allowed_number'];
$spotsLeft = $event['allowed_number'] - ($event['registration_count'] ?? 0);
$fillPercentage = (($event['registration_count'] ?? 0) / $event['allowed_number']) * 100;
?>

<div class="container mt-4">
    <!-- Back Navigation -->
    <div class="mb-3">
        <a href="<?= PROJECT_URL; ?>/Index.php?event/index" class="btn btn-link">
            ← Back to Events
        </a>
    </div>

    <div class="row">
        <!-- Main Event Details Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Event Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <!-- Event Title -->
                            <h1 class="h2"><?= htmlspecialchars($event['name']) ?></h1>
                            
                            <!-- Event Type Badge -->
                            <span class="badge bg-primary">
                                <?= ucfirst($event['type']) ?>
                            </span>
                        </div>
                        
                        <!-- Price Display -->
                        <div class="text-end">
                            <div class="h3 text-primary">
                                <?= $event['price'] > 0 ? '$' . number_format($event['price'], 2) : 'FREE' ?>
                            </div>
                            <?php if ($event['price'] > 0): ?>
                                <small class="text-muted">per person</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="mb-4">
                        <h3 class="h5">About This Event</h3>
                        <p class="text-muted">
                            <?= htmlspecialchars($event['description']) ?>
                        </p>
                    </div>

                    <!-- Event Details Grid -->
                    <div class="row g-3 mb-4">
                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="me-2">📅</span>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <strong><?= date('l, F j, Y', strtotime($event['date'])) ?></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="me-2">🕐</span>
                                <div>
                                    <small class="text-muted d-block">Time</small>
                                    <strong><?= $event['time'] ?> - <?= $event['end_time'] ?></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Venue -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="me-2">📍</span>
                                <div>
                                    <small class="text-muted d-block">Venue</small>
                                    <strong><?= htmlspecialchars($event['venue_name']) ?></strong>
                                    <?php if (isset($event['venue_address'])): ?>
                                        <small class="text-muted d-block">
                                            <?= htmlspecialchars($event['venue_address']) ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Organizer -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="me-2">🏢</span>
                                <div>
                                    <small class="text-muted d-block">Organizer</small>
                                    <strong><?= htmlspecialchars($event['organizer']) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Capacity Information -->
                    <div class="mb-4">
                        <h3 class="h5">Registration Status</h3>
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-2" style="height: 25px;">
                            <div class="progress-bar <?= $isFull ? 'bg-danger' : 'bg-success' ?>" 
                                 role="progressbar" 
                                 style="width: <?= $fillPercentage ?>%"
                                 aria-valuenow="<?= $event['registration_count'] ?? 0 ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="<?= $event['allowed_number'] ?>">
                                <?= $event['registration_count'] ?? 0 ?> / <?= $event['allowed_number'] ?>
                            </div>
                        </div>
                        
                        <!-- Status Text -->
                        <p class="<?= $isFull ? 'text-danger' : 'text-success' ?>">
                            <?php if ($isFull): ?>
                                <strong>This event is full!</strong> Join the waiting list below.
                            <?php else: ?>
                                <strong><?= $spotsLeft ?> spots remaining!</strong> Register now to secure your place.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Registration Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 mb-3">Registration</h3>
                    
                    <?php if (!empty($_SESSION['user'])): ?>
                        <?php if (!$isFull): ?>
                            <!-- Register Button -->
                            <a href="<?= PROJECT_URL; ?>/Index.php?event/register&id=<?= $event['event_id'] ?>" 
                               class="btn btn-primary btn-lg w-100 mb-2">
                                Register Now
                            </a>
                            <p class="text-muted small text-center mb-0">
                                Secure your spot immediately
                            </p>
                        <?php else: ?>
                            <!-- Waiting List Button -->
                            <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                                Join Waiting List
                            </button>
                            <p class="text-muted small text-center mb-0">
                                We'll notify you if spots become available
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Login Required -->
                        <a href="<?= PROJECT_URL; ?>/Index.php?user/login" 
                           class="btn btn-outline-primary btn-lg w-100 mb-2">
                            Login to Register
                        </a>
                        <p class="text-muted small text-center mb-0">
                            You must be logged in to register for events
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Admin Actions Card (if admin) -->
            <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Admin Actions</h3>
                        
                        <!-- Edit Event -->
                        <a href="<?= PROJECT_URL; ?>/Index.php?event/edit&id=<?= $event['event_id'] ?>" 
                           class="btn btn-warning w-100 mb-2">
                            Edit Event
                        </a>
                        
                        <!-- Delete Event -->
                        <a href="<?= PROJECT_URL; ?>/Index.php?event/delete&id=<?= $event['event_id'] ?>" 
                           class="btn btn-danger w-100"
                           onclick="return confirm('Are you sure you want to delete this event?')">
                            Delete Event
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Venue Information Card -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h3 class="h5 mb-3">Venue Details</h3>
                    <p class="mb-2">
                        <strong><?= htmlspecialchars($event['venue_name']) ?></strong>
                    </p>
                    <?php if (isset($event['venue_address'])): ?>
                        <p class="text-muted small mb-2">
                            <?= htmlspecialchars($event['venue_address']) ?>
                        </p>
                    <?php endif; ?>
                    <p class="text-muted small mb-0">
                        <strong>Capacity:</strong> <?= number_format($event['venue_capacity']) ?> people
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
