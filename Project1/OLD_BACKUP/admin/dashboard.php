    <div class="main-content">
        <div class="content-card">
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">System overview and management</p>
            
            <!-- Admin Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <span class="stat-number"><?php echo $data['stats']['total_users']; ?></span>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <span class="stat-number"><?php echo $data['stats']['total_events']; ?></span>
                    <div class="stat-label">Total Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <span class="stat-number"><?php echo $data['stats']['upcoming_events']; ?></span>
                    <div class="stat-label">Upcoming Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <span class="stat-number">$<?php echo number_format($data['stats']['total_revenue'], 2); ?></span>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Recent Users</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 10px; text-align: left;">Username</th>
                        <th style="padding: 10px; text-align: left;">Email</th>
                        <th style="padding: 10px; text-align: left;">Role</th>
                        <th style="padding: 10px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($data['recent_users'], 0, 5) as $user): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td style="padding: 10px;"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td style="padding: 10px;">
                            <span class="status-badge" style="background: <?php echo $user['role'] === 'admin' ? '#ef4444' : ($user['role'] === 'organizer' ? '#3b82f6' : '#10b981'); ?>; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td style="padding: 10px;">
                            <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=editUser&username=<?php echo $user['username']; ?>" style="color: #3b82f6;">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 20px;">
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=users" class="btn">View All Users</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=users" class="btn" style="text-decoration: none; text-align: center;">👥 Manage Users</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=event&action=list" class="btn" style="text-decoration: none; text-align: center; background: linear-gradient(135deg, #8b5cf6, #ec4899);">📅 Manage Events</a>
                <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=settings" class="btn" style="text-decoration: none; text-align: center; background: linear-gradient(135deg, #06b6d4, #3b82f6);">⚙️ System Settings</a>
            </div>
        </div>
    </div>
