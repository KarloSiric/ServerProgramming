<?php 
/**
 * @file index.php
 * @brief Event listing view - Shows all available events
 * 
 * Displays a grid of all events with registration status.
 * Different views for guests, attendees, and admins.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Called by EventController::index()
 * @see EventController::index()
 * 
 * @var array $events All events from AppModel (via header.php)
 * @var array $user Current user session data
 */

// Get user data with fallback
$u = $user ?? ['username' => 'user']; 
?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Available Events</h2>
        </div>
        <div class="card-body">
            <?php 
            /**
             * Display flash messages
             * Shows success/error messages after actions
             */
            if (!empty($_SESSION['flash'])): ?>
                <?php require 'app/view/inc/flash.php'; ?>
            <?php endif; ?>
            
            <!-- Events Grid -->
            <div class="events-grid">
                <?php 
                /**
                 * Loop through all events
                 * Each event gets a card with details and actions
                 */
                foreach ($events as $event): 
                    /**
                     * Calculate registration status
                     * Check if current event is at capacity
                     */
                    $isFull = $event['registration_count'] >= $event['allowed_number'];
                    $spotsLeft = $event['allowed_number'] - $event['registration_count'];
                ?>
                    <!-- Individual Event Card -->
                    <div class="event-card">
                        <!-- Event Type Badge -->
                        <div class="event-type <?= $event['type'] ?>">
                            <?= ucfirst($event['type']) ?>
                        </div>
                        
                        <!-- Event Title -->
                        <h3><?= htmlspecialchars($event['name']) ?></h3>
                        
                        <!-- Event Description -->
                        <p class="event-description">
                            <?= htmlspecialchars($event['description']) ?>
                        </p>
                        
                        <!-- Event Metadata Grid -->
                        <div class="event-meta">
                            <!-- Date Information -->
                            <div>
                                <span class="icon">📅</span>
                                <span><?= date('M d, Y', strtotime($event['date'])) ?></span>
                            </div>
                            
                            <!-- Time Information -->
                            <div>
                                <span class="icon">🕐</span>
                                <span><?= $event['time'] ?> - <?= $event['end_time'] ?></span>
                            </div>
                            
                            <!-- Venue Information -->
                            <div>
                                <span class="icon">📍</span>
                                <span><?= htmlspecialchars($event['venue_name']) ?></span>
                            </div>
                            
                            <!-- Price Information -->
                            <div>
                                <span class="icon">💵</span>
                                <span><?= $event['price'] > 0 ? '$' . number_format($event['price'], 2) : 'Free' ?></span>
                            </div>
                        </div>
                        
                        <!-- Registration Status Bar -->
                        <div class="registration-status">
                            <div class="status-bar">
                                <?php 
                                /**
                                 * Calculate and display fill percentage
                                 * Shows visual representation of registration capacity
                                 */
                                $fillPercentage = ($event['registration_count'] / $event['allowed_number']) * 100;
                                ?>
                                <div class="status-fill" style="width: <?= $fillPercentage ?>%"></div>
                            </div>
                            <div class="status-text">
                                <?php if ($isFull): ?>
                                    <span class="text-danger">Event Full</span>
                                <?php else: ?>
                                    <span><?= $spotsLeft ?> spots left</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="event-actions">
                            <!-- View Details Button (always shown) -->
                            <a href="<?= PROJECT_URL; ?>/Index.php?event/show&id=<?= $event['event_id'] ?>" 
                               class="btn btn-outline">View Details</a>
                            
                            <?php if ($user): ?>
                                <?php if (!$isFull): ?>
                                    <!-- Register Button (for logged-in users, if space available) -->
                                    <a href="<?= PROJECT_URL; ?>/Index.php?event/register&id=<?= $event['event_id'] ?>" 
                                       class="btn btn-primary">Register</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- Login Prompt (for guests) -->
                                <a href="<?= PROJECT_URL; ?>/Index.php?user/login" 
                                   class="btn btn-secondary">Login to Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php 
            /**
             * Show empty state if no events
             */
            if (empty($events)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">No events available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
