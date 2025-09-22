<?php
// Mock database statistics
$dbStats = [
    'connection_status' => 'Connected',
    'database_size' => '2.4 GB',
    'active_connections' => '12/100',
    'last_backup' => '2 hours ago',
    'avg_response_time' => '45ms',
    'queries_per_sec' => '1,247',
    'cache_hit_rate' => '99.2%',
    'error_rate' => '0.01%'
];
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">🗄️</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Database</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <span>🔔</span>
                <span>⚙️</span>
            </div>
        </div>
        <h1>Data Console</h1>
        <p>Database management and monitoring</p>
    </div>

    <!-- Database Status Overview -->
    <div class="metrics-grid">
        <!-- Database Status -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">🗄️ Database Status</h3>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="metric-item">
                    <div class="metric-label">Connection Status</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-badge excellent"><?= $dbStats['connection_status'] ?></div>
                    </div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Database Size</div>
                    <div class="metric-value"><?= $dbStats['database_size'] ?></div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Active Connections</div>
                    <div class="metric-value"><?= $dbStats['active_connections'] ?></div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Last Backup</div>
                    <div class="metric-value"><?= $dbStats['last_backup'] ?></div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">📈 Performance Metrics</h3>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="metric-item">
                    <div class="metric-label">Avg Response Time</div>
                    <div class="metric-value" style="color: #059669;"><?= $dbStats['avg_response_time'] ?></div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Queries/sec</div>
                    <div class="metric-value"><?= $dbStats['queries_per_sec'] ?></div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Cache Hit Rate</div>
                    <div class="metric-value" style="color: #059669;"><?= $dbStats['cache_hit_rate'] ?></div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Error Rate</div>
                    <div class="metric-value" style="color: #059669;"><?= $dbStats['error_rate'] ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Database Tables -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Database Tables</h3>
            <p class="admin-card-subtitle">Table statistics and information</p>
        </div>
        <div class="admin-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Records</th>
                        <th>Size</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>users</strong></td>
                        <td>2,847</td>
                        <td>156 KB</td>
                        <td>2 mins ago</td>
                        <td>
                            <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>events</strong></td>
                        <td>42</td>
                        <td>89 KB</td>
                        <td>5 mins ago</td>
                        <td>
                            <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>registrations</strong></td>
                        <td>1,249</td>
                        <td>234 KB</td>
                        <td>1 min ago</td>
                        <td>
                            <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>venues</strong></td>
                        <td>15</td>
                        <td>12 KB</td>
                        <td>1 hour ago</td>
                        <td>
                            <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>sessions</strong></td>
                        <td>1,247</td>
                        <td>67 KB</td>
                        <td>30 secs ago</td>
                        <td>
                            <button class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 12px;">
                                View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Database Actions -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Database Operations</h3>
            <p class="admin-card-subtitle">Maintenance and backup operations</p>
        </div>
        <div class="admin-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <button class="btn-admin btn-admin-primary" style="padding: 12px; text-align: center;">
                    <span>💾</span><br>
                    <strong>Create Backup</strong><br>
                    <small>Full database backup</small>
                </button>
                <button class="btn-admin btn-admin-secondary" style="padding: 12px; text-align: center;">
                    <span>🔄</span><br>
                    <strong>Optimize Tables</strong><br>
                    <small>Improve performance</small>
                </button>
                <button class="btn-admin btn-admin-outline" style="padding: 12px; text-align: center;">
                    <span>📊</span><br>
                    <strong>Query Analyzer</strong><br>
                    <small>Analyze slow queries</small>
                </button>
                <button class="btn-admin btn-admin-outline" style="padding: 12px; text-align: center;">
                    <span>🧹</span><br>
                    <strong>Cleanup Data</strong><br>
                    <small>Remove old records</small>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Close admin layout -->
</div>
</div>
