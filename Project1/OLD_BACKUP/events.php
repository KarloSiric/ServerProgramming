<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];

// Sample events data
$events = [
    [
        'id' => 1,
        'title' => 'Tech Conference 2024',
        'date' => '2024-12-15',
        'time' => '09:00',
        'location' => 'Convention Center',
        'attendees' => 150,
        'status' => 'upcoming'
    ],
    [
        'id' => 2,
        'title' => 'Marketing Workshop',
        'date' => '2024-12-08',
        'time' => '14:00',
        'location' => 'Business Hub',
        'attendees' => 45,
        'status' => 'upcoming'
    ],
    [
        'id' => 3,
        'title' => 'Design Meetup',
        'date' => '2024-11-28',
        'time' => '18:30',
        'location' => 'Creative Space',
        'attendees' => 32,
        'status' => 'completed'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - EventPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">EventPro</a>
            <ul class="nav-links">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="events.php" class="active">Events</a></li>
                <li><a href="venues.php">Venues</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <div class="content-card">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Events</h1>
                    <p class="page-subtitle">Manage and organize your events</p>
                </div>
                <button class="btn" onclick="showCreateModal()">+ Create Event</button>
            </div>
            
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <button class="tab-btn active" onclick="filterEvents('all')">All Events</button>
                <button class="tab-btn" onclick="filterEvents('upcoming')">Upcoming</button>
                <button class="tab-btn" onclick="filterEvents('completed')">Completed</button>
            </div>
            
            <!-- Events Grid -->
            <div class="events-grid">
                <?php foreach ($events as $event): ?>
                <div class="event-card" data-status="<?php echo $event['status']; ?>">
                    <div class="event-header">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <span class="status-badge status-<?php echo $event['status']; ?>">
                            <?php echo ucfirst($event['status']); ?>
                        </span>
                    </div>
                    <div class="event-details">
                        <div class="event-detail">
                            <span class="detail-icon">📅</span>
                            <span><?php echo date('M j, Y', strtotime($event['date'])); ?></span>
                        </div>
                        <div class="event-detail">
                            <span class="detail-icon">⏰</span>
                            <span><?php echo date('g:i A', strtotime($event['time'])); ?></span>
                        </div>
                        <div class="event-detail">
                            <span class="detail-icon">📍</span>
                            <span><?php echo htmlspecialchars($event['location']); ?></span>
                        </div>
                        <div class="event-detail">
                            <span class="detail-icon">👥</span>
                            <span><?php echo $event['attendees']; ?> attendees</span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <button class="btn-small btn-outline">Edit</button>
                        <button class="btn-small btn-outline">View</button>
                        <button class="btn-small btn-danger">Delete</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Create Event Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Event</h3>
                <button class="close-btn" onclick="hideCreateModal()">&times;</button>
            </div>
            <form class="modal-form">
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Event title" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Location" required>
                </div>
                <div class="form-group">
                    <textarea class="form-input" placeholder="Event description" rows="3"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="hideCreateModal()">Cancel</button>
                    <button type="submit" class="btn">Create Event</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
        }
        
        function hideCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }
        
        function filterEvents(status) {
            const cards = document.querySelectorAll('.event-card');
            const tabs = document.querySelectorAll('.tab-btn');
            
            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // Close modal when clicking outside
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideCreateModal();
            }
        });
    </script>
</body>
</html>
