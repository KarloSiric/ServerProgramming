<?php $u = $user ?? ['username' => 'user']; ?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>All Events</h2>
        </div>
        <div class="card-body">
            <?php if (($u['role'] ?? '') === 'admin'): ?>
                <a href="/event/create" class="btn btn-success">Create New Event</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($events)): ?>
        <div class="card">
            <div class="card-body">
                <p>No events found.</p>
                <?php if (($u['role'] ?? '') === 'admin'): ?>
                    <a href="/event/create" class="btn btn-success">Create First Event</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-2">
            <?php foreach ($events as $event): ?>
                <div class="card event-card">
                    <div class="event-header">
                        <h3 class="event-title"><?= htmlspecialchars($event['name']) ?></h3>
                        <p><?= htmlspecialchars($event['type']) ?> - <?= htmlspecialchars($event['date']) ?></p>
                    </div>
                    <div class="card-body">
                        <p><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                        
                        <div class="event-info">
                            <div class="info-item">
                                <strong>Venue:</strong><br>
                                <?= htmlspecialchars($event['venue_name']) ?>
                            </div>
                            <div class="info-item">
                                <strong>Capacity:</strong><br>
                                <?= number_format($event['venue_capacity']) ?> people
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            <a href="/event/view?id=<?= $event['id'] ?>" class="btn btn-outline">View Details</a>
                            <?php if (($u['role'] ?? '') !== 'admin'): ?>
                                <button class="btn btn-success">Register</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
