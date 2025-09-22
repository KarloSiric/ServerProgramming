<?php
$userModel = new UserModel();
$users = $userModel->getAllUsers();
$userStats = $userModel->getUserStats();
$recentActivity = $userModel->getRecentActivity();
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">👥</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Users</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <span>🔔</span>
                <span>⚙️</span>
            </div>
        </div>
        <h1>User Management</h1>
        <p>Monitor user activity and registrations</p>
    </div>

    <!-- User Stats -->
    <div class="stats-overview" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Total Users</div>
                <div class="stat-icon">👥</div>
            </div>
            <div class="stat-value">2,847</div>
            <div class="stat-change positive">+12% this month</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Active Sessions</div>
                <div class="stat-icon">💻</div>
            </div>
            <div class="stat-value">1,247</div>
            <div class="stat-change">Online now</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">New Registrations</div>
                <div class="stat-icon">✨</div>
            </div>
            <div class="stat-value">94</div>
            <div class="stat-change">Last 24 hours</div>
        </div>
    </div>

    <!-- Recent User Activity -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Recent User Activity</h3>
            <p class="admin-card-subtitle">Latest user registrations and actions</p>
        </div>
        <div class="admin-card-body">
            <?php foreach ($recentActivity as $activity): ?>
            <div class="activity-item">
                <div class="activity-avatar"><?= $activity['avatar'] ?></div>
                <div class="activity-content">
                    <div class="activity-user"><?= htmlspecialchars($activity['user']) ?></div>
                    <div class="activity-email"><?= htmlspecialchars($activity['email']) ?></div>
                    <div class="activity-action"><?= htmlspecialchars($activity['action']) ?></div>
                </div>
                <div class="activity-time"><?= $activity['time'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- User List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">All Users</h3>
            <p class="admin-card-subtitle">Complete list of registered users</p>
        </div>
        <div class="admin-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div class="activity-avatar" style="width: 24px; height: 24px; font-size: 10px;">
                                    <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                </div>
                                <div>
                                    <div style="font-weight: 500;"><?= htmlspecialchars($user['name']) ?></div>
                                    <div style="font-size: 12px; color: #64748b;">@<?= htmlspecialchars($user['username']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; 
                                         background: <?= $user['role'] === 'admin' ? '#dbeafe' : '#f3f4f6' ?>; 
                                         color: <?= $user['role'] === 'admin' ? '#2563eb' : '#374151' ?>;">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td style="color: #64748b; font-size: 14px;">
                            <?= date('M j, Y', strtotime($user['created_at'] ?? '2024-01-01')) ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 4px;">
                                <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                    Edit
                                </button>
                                <button class="btn-admin btn-admin-secondary" style="padding: 4px 8px; font-size: 12px;">
                                    View
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Close admin layout -->
</div>
</div>
