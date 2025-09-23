<?php
$eventModel = new EventModel();
$events = $eventModel->getAllEvents();
$eventStats = $eventModel->getEventStats();
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">📅</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Events</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <span>🔔</span>
                <span>⚙️</span>
            </div>
        </div>
        <h1>Event Management</h1>
        <p>Create, edit, and monitor your events</p>
    </div>

    <!-- Action Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="search-section" style="margin: 0; flex: 1; max-width: 400px;">
            <input type="text" class="search-input" placeholder="Search events..." style="margin: 0;">
        </div>
        <a href="?event/create" class="btn-admin btn-admin-primary">
            <span>➕</span> Create Event
        </a>
    </div>

    <!-- Filter Controls -->
    <div style="display: flex; gap: 8px; margin-bottom: 24px;">
        <button class="btn-admin btn-admin-outline">
            <span>🔽</span> Filters
        </button>
    </div>

    <!-- Events Grid -->
    <div class="events-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
        <?php foreach ($events as $event): ?>
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="position: relative;">
                <div style="width: 100%; height: 180px; background-image: url('/~ks9700/iste-341/Project1/public/img/Project1_image1.png'); background-size: cover; background-position: center; border-radius: 8px 8px 0 0;">
                    <div style="position: absolute; top: 12px; left: 12px; background: rgba(0, 0, 0, 0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        <?= htmlspecialchars($event['type']) ?>
                    </div>
                    <div style="position: absolute; top: 12px; right: 12px; background: rgba(0, 0, 0, 0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        $<?= $event['price'] ?? 299 ?>
                    </div>
                </div>
            </div>
            
            <div style="padding: 20px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: #1e293b;">
                    <?= htmlspecialchars($event['name']) ?>
                </h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 16px; line-height: 1.5;">
                    <?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...
                </p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b;">
                        <span>📅</span>
                        <div>
                            <div style="font-weight: 500; color: #374151;"><?= date('M j, Y', strtotime($event['date'])) ?></div>
                            <div><?= $event['time'] ?? '9:00 AM' ?> - <?= $event['end_time'] ?? '6:00 PM' ?></div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b;">
                        <span>📍</span>
                        <div>
                            <div style="font-weight: 500; color: #374151;"><?= htmlspecialchars($event['venue_name']) ?></div>
                            <div><?= $event['registration_count'] ?? 0 ?>/<?= $event['venue_capacity'] ?> registered</div>
                        </div>
                    </div>
                </div>

                <div style="font-size: 12px; color: #64748b; margin-bottom: 16px;">
                    <span>👤</span>
                    Organized by <?= $event['organizer'] ?? 'Event Foundation' ?>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="?event/edit/<?= $event['id'] ?>" class="btn-admin btn-admin-outline" style="flex: 1; text-align: center; padding: 8px;">
                        Edit
                    </a>
                    <button class="btn-admin btn-admin-danger" style="flex: 1; padding: 8px;" onclick="confirmDelete(<?= $event['id'] ?>)">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Close admin layout -->
</div>
</div>

<script>
function confirmDelete(eventId) {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        // In a real app, this would make an AJAX request
        window.location.href = '?event/delete/' + eventId;
    }
}
</script>
