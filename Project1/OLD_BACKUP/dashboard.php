    <div class="main-content">
        <div class="content-card">
            <h1 class="page-title">Welcome back, <?php echo htmlspecialchars($data['user']['username']); ?>! ✨</h1>
            <p class="page-subtitle">Here's what's happening with your events today</p>
            
            <?php if ($data['user']['role'] === 'organizer'): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <span class="stat-number"><?php echo $data['stats']['events']; ?></span>
                    <div class="stat-label">Active Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <span class="stat-number"><?php echo $data['stats']['venues']; ?></span>
                    <div class="stat-label">Venues</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <span class="stat-number"><?php echo $data['stats']['attendees']; ?></span>
                    <div class="stat-label">Attendees</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <span class="stat-number">4.8</span>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
            <?php elseif ($data['user']['role'] === 'attendee'): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🎫</div>
                    <span class="stat-number"><?php echo $data['stats']['upcoming']; ?></span>
                    <div class="stat-label">Upcoming Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <span class="stat-number"><?php echo $data['stats']['events']; ?></span>
                    <div class="stat-label">Total Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <span class="stat-number"><?php echo $data['stats']['venues']; ?></span>
                    <div class="stat-label">Venues Visited</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <span class="stat-number">New</span>
                    <div class="stat-label">Member Status</div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <?php if ($data['user']['role'] === 'organizer'): ?>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=create" class="btn" style="text-decoration: none; text-align: center; display: block;">➕ Create Event</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=list" class="btn" style="text-decoration: none; text-align: center; display: block;">📝 Manage Events</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=venue&action=list" class="btn" style="text-decoration: none; text-align: center; display: block; background: linear-gradient(135deg, #06b6d4, #8b5cf6);">🏢 View Venues</a>
                <?php else: ?>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=list" class="btn" style="text-decoration: none; text-align: center; display: block;">🎫 Browse Events</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=venue&action=list" class="btn" style="text-decoration: none; text-align: center; display: block; background: linear-gradient(135deg, #06b6d4, #8b5cf6);">🏢 Explore Venues</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
