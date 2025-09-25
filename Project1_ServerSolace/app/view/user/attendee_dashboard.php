<?php 
$u = $user ?? ['username' => 'guest']; 
$eventModel = new EventModel();
$events = $eventModel->getAllEvents();
?>

<div class="main-content">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-header">
            <div class="welcome-text">
                <h1>Welcome back, <?= htmlspecialchars($u['name'] ?? $u['username']) ?>! ⭐</h1>
                <p>Ready to explore the next horizon of tech events?</p>
            </div>
            <div class="welcome-stats">
                <div class="stat-item">
                    <h2>2</h2>
                    <p>Events Joined</p>
                </div>
                <div class="stat-item">
                    <h2>2</h2>
                    <p>Saved Events</p>
                </div>
                <div class="stat-item">
                    <h2>$299</h2>
                    <p>Total Invested</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="dashboard-card blue">
                <h3>2</h3>
                <p>Registered Events</p>
                <div class="small-text">0 upcoming</div>
            </div>
            <div class="dashboard-card green">
                <h3>5</h3>
                <p>Available Events</p>
                <div class="small-text">5 open for registration</div>
            </div>
            <div class="dashboard-card purple">
                <h3>2</h3>
                <p>Saved Events</p>
                <div class="small-text">Bookmarked for later</div>
            </div>
            <div class="dashboard-card orange">
                <h3>20%</h3>
                <p>Learning Progress</p>
                <div class="progress-section">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 20%;"></div>
                    </div>
                    <div class="small-text">Goal: 10 events this year</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs">
        <button class="nav-tab active">Discover</button>
        <button class="nav-tab">My Events</button>
        <button class="nav-tab">Saved</button>
        <button class="nav-tab">For You</button>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <input type="text" class="search-input" placeholder="Search events, organizers, or topics...">
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-tags">
            <button class="filter-tag active">
                All Events
                <span class="count">5</span>
            </button>
            <button class="filter-tag">
                Conferences
                <span class="count">2</span>
            </button>
            <button class="filter-tag">
                Workshops
                <span class="count">2</span>
            </button>
            <button class="filter-tag">
                Networking
                <span class="count">1</span>
            </button>
            <button class="filter-tag">
                Webinars
                <span class="count">0</span>
            </button>
        </div>
        <div class="view-controls">
            <button class="view-btn active">⊞ Filters</button>
            <button class="view-btn">⊟</button>
            <button class="view-btn">☰</button>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="events-grid">
        <?php foreach (array_slice($events, 0, 6) as $event): ?>
        <div class="event-card">
            <div class="event-image" style="background-image: url('/public/img/Project1_image1.png');">
                <div class="event-tag"><?= htmlspecialchars($event['type']) ?></div>
                <div class="event-price">$<?= $event['price'] ?? 299 ?></div>
            </div>
            <div class="event-content">
                <h3 class="event-title"><?= htmlspecialchars($event['name']) ?></h3>
                <p class="event-description">
                    <?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...
                </p>
                
                <div class="event-details">
                    <div class="event-detail">
                        <span class="icon">📅</span>
                        <div>
                            <div><?= date('M j, Y', strtotime($event['date'])) ?></div>
                            <div><?= $event['time'] ?? '9:00 AM' ?> - <?= $event['end_time'] ?? '6:00 PM' ?></div>
                        </div>
                    </div>
                    <div class="event-detail">
                        <span class="icon">📍</span>
                        <div>
                            <div><?= htmlspecialchars($event['venue_name']) ?></div>
                            <div><?= $event['registration_count'] ?? 0 ?>/<?= $event['venue_capacity'] ?> registered</div>
                        </div>
                    </div>
                </div>

                <div class="event-organizer">
                    <span class="icon">👤</span>
                    Organized by <?= $event['organizer'] ?? 'Event Foundation' ?>
                </div>

                <div class="event-actions">
                    <a href="/event/view?id=<?= $event['id'] ?>" class="btn btn-view">View Details</a>
                    <?php if (isset($event['registered']) && $event['registered']): ?>
                        <button class="btn btn-registered">Registered</button>
                    <?php else: ?>
                        <button class="btn btn-register">Register</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Tab switching functionality
document.querySelectorAll('.nav-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});

// Filter switching
document.querySelectorAll('.filter-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});

// View controls
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
