<div class="main-content">
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-header">
            <div class="welcome-text">
                <h1>Welcome back, <?= htmlspecialchars($user['name']) ?>! 👋</h1>
                <p>Ready to discover amazing tech events? Your next breakthrough is just an event away.</p>
            </div>
            <div class="welcome-stats">
                <div class="stat-item">
                    <h2><?= count($events) ?></h2>
                    <p>Available Events</p>
                </div>
                <div class="stat-item">
                    <h2>12</h2>
                    <p>Registered Events</p>
                </div>
                <div class="stat-item">
                    <h2>4.9</h2>
                    <p>Avg Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
        <div class="dashboard-card blue">
            <h3>24</h3>
            <p>Events This Month</p>
            <div class="progress-section">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%;"></div>
                </div>
                <div class="small-text">75% capacity filled</div>
            </div>
        </div>
        
        <div class="dashboard-card green">
            <h3>89%</h3>
            <p>Attendance Rate</p>
            <div class="progress-section">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 89%;"></div>
                </div>
                <div class="small-text">Above average</div>
            </div>
        </div>
        
        <div class="dashboard-card purple">
            <h3>156</h3>
            <p>Network Connections</p>
            <div class="progress-section">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 65%;"></div>
                </div>
                <div class="small-text">Growing network</div>
            </div>
        </div>
        
        <div class="dashboard-card orange">
            <h3>$2,400</h3>
            <p>Saved on Events</p>
            <div class="progress-section">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 80%;"></div>
                </div>
                <div class="small-text">Smart choices</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs">
        <button class="nav-tab active">All Events</button>
        <button class="nav-tab">Upcoming</button>
        <button class="nav-tab">Past</button>
        <button class="nav-tab">Registered</button>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <input type="text" class="search-input" placeholder="Search events by name, topic, or organizer...">
        <button class="btn btn-primary">Search</button>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-tags">
            <div class="filter-tag active">
                All <span class="count"><?= count($events) ?></span>
            </div>
            <div class="filter-tag">
                Conference <span class="count">2</span>
            </div>
            <div class="filter-tag">
                Workshop <span class="count">2</span>
            </div>
            <div class="filter-tag">
                Networking <span class="count">1</span>
            </div>
        </div>
        
        <div class="view-controls">
            <button class="view-btn active">Grid</button>
            <button class="view-btn">List</button>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="events-grid">
        <?php 
        $eventImages = [
            1 => 'Project1_image1.png',
            2 => 'Project1_Image2.png', 
            3 => 'Project1_Image3.png',
            4 => 'Project1_image1.png',
            5 => 'Project1_Image2.png'
        ];
        foreach ($events as $event): 
            $imagePath = PROJECT_URL . '/public/img/' . ($eventImages[$event['event_id']] ?? 'Project1_image1.png');
        ?>
        <div class="event-card">
            <div class="event-image" style="background-image: url('<?= $imagePath ?>'); background-size: cover; background-position: center;">
                <div class="event-tag"><?= ucfirst($event['type']) ?></div>
                <div class="event-price"><?= $event['price'] == 0 ? 'Free' : '$' . $event['price'] ?></div>
            </div>
            <div class="event-content">
                <h3 class="event-title"><?= htmlspecialchars($event['name']) ?></h3>
                <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>
                
                <div class="event-details">
                    <div class="event-detail">
                        <span class="icon">📅</span>
                        <span><?= date('M j, Y', strtotime($event['date'])) ?></span>
                    </div>
                    <div class="event-detail">
                        <span class="icon">⏰</span>
                        <span><?= $event['time'] ?></span>
                    </div>
                    <div class="event-detail">
                        <span class="icon">📍</span>
                        <span><?= htmlspecialchars($event['venue_name']) ?></span>
                    </div>
                    <div class="event-detail">
                        <span class="icon">👥</span>
                        <span><?= $event['venue_capacity'] ?> spots</span>
                    </div>
                </div>
                
                <div class="event-organizer">
                    Organized by <strong><?= htmlspecialchars($event['organizer']) ?></strong>
                </div>
                
                <div class="event-actions">
                    <a href="<?= PROJECT_URL; ?>/Index.php?event/show&id=<?= $event['event_id'] ?>" class="btn btn-view">View Details</a>
                    <a href="<?= PROJECT_URL; ?>/Index.php?event/register&id=<?= $event['event_id'] ?>" class="btn btn-register">
                        <?= $event['price'] == 0 ? 'Join Free' : '$' . $event['price'] . ' Register' ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
