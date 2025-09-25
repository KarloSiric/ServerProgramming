    <div class="main-content">
        <div class="content-card">
            <?php if (($user['role'] ?? '') === 'admin'): ?>
                <!-- ADMIN VIEW -->
                <h1>🔐 ADMIN DASHBOARD</h1>
                <h2>Welcome, Administrator <?php echo htmlspecialchars($user['username'] ?? 'Admin'); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($user['email'] ?? 'admin@eventhorizon.com'); ?></p>
                
                <div class="admin-panel" style="margin-top: 30px; padding: 20px; background: #f3f4f6; border-radius: 10px;">
                    <h3>Admin Controls</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin: 10px 0;">✓ Manage Events</li>
                        <li style="margin: 10px 0;">✓ Manage Venues</li>
                        <li style="margin: 10px 0;">✓ View Reports</li>
                        <li style="margin: 10px 0;">✓ User Management</li>
                    </ul>
                </div>
                
            <?php else: ?>
                <!-- ATTENDEE VIEW -->
                <h1>🎉 ATTENDEE DASHBOARD</h1>
                <h2>Welcome, <?php echo htmlspecialchars($user['username'] ?? 'Guest'); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($user['email'] ?? 'user@eventhorizon.com'); ?></p>
                
                <div class="attendee-panel" style="margin-top: 30px; padding: 20px; background: #f0fdf4; border-radius: 10px;">
                    <h3>Your Event Tools</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin: 10px 0;">✓ Browse Events</li>
                        <li style="margin: 10px 0;">✓ Register for Events</li>
                        <li style="margin: 10px 0;">✓ View Your Registrations</li>
                        <li style="margin: 10px 0;">✓ Event Calendar</li>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 30px;">
                <a href="<?php echo PROJECT_URL; ?>/Index.php?user/logout" class="btn btn-danger">Logout</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?user/dashboard" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>
