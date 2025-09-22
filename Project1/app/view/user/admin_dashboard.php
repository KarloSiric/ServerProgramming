<?php 
$u = $user ?? ['username' => 'admin']; 
$eventModel = new EventModel();
$venueModel = new VenueModel();
$userModel = new UserModel();

$events = $eventModel->getAllEvents();
$venues = $venueModel->getAllVenues();
$users = $userModel->getAllUsers();
?>

<div class="main-content">
    <div class="card admin-card">
        <div class="card-header">
            <h2>Admin Dashboard</h2>
        </div>
        <div class="card-body">
            <p>Welcome, <?= htmlspecialchars($u['name']) ?>. Manage events and venues from here.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($events) ?></div>
            <div class="stat-label">Total Events</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($venues) ?></div>
            <div class="stat-label">Total Venues</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($users) ?></div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="grid grid-2">
        <!-- Events Management -->
        <div class="card admin-card">
            <div class="card-header">
                <h3>Event Management</h3>
            </div>
            <div class="card-body">
                <p>Create, edit, and manage all events.</p>
                <div style="margin-top: 15px;">
                    <a href="/event/list" class="btn btn-primary">View All Events</a>
                    <a href="/event/create" class="btn btn-success">Create Event</a>
                </div>
            </div>
        </div>

        <!-- Venues Management -->
        <div class="card admin-card">
            <div class="card-header">
                <h3>Venue Management</h3>
            </div>
            <div class="card-body">
                <p>Add, edit, and manage venue locations.</p>
                <div style="margin-top: 15px;">
                    <a href="/venue/list" class="btn btn-primary">View All Venues</a>
                    <a href="/venue/create" class="btn btn-success">Add Venue</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events Table -->
    <div class="card admin-card">
        <div class="card-header">
            <h3>Recent Events</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($events, 0, 5) as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['venue_name']) ?></td>
                        <td><?= htmlspecialchars($event['type']) ?></td>
                        <td>
                            <a href="/event/view?id=<?= $event['id'] ?>" class="btn btn-outline">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
