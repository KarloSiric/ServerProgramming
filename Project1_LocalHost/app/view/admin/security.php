<?php
// Mock security data
$securityStats = [
    'active_sessions' => 1247,
    'failed_logins' => 3,
    'security_score' => 98,
    'last_security_scan' => '2 hours ago'
];
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">🔒</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Security</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <span>🔔</span>
                <span>⚙️</span>
            </div>
        </div>
        <h1>Security Console</h1>
        <p>Access control and security monitoring</p>
    </div>

    <!-- Security Stats -->
    <div class="stats-overview" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Active Sessions</div>
                <div class="stat-icon">💻</div>
            </div>
            <div class="stat-value"><?= number_format($securityStats['active_sessions']) ?></div>
            <div class="stat-change">All authenticated</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Failed Logins</div>
                <div class="stat-icon">⚠️</div>
            </div>
            <div class="stat-value"><?= $securityStats['failed_logins'] ?></div>
            <div class="stat-change">Last 24 hours</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Security Score</div>
                <div class="stat-icon">🛡️</div>
            </div>
            <div class="stat-value"><?= $securityStats['security_score'] ?>%</div>
            <div class="stat-change positive">Excellent</div>
        </div>
    </div>

    <!-- Security Features -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Security Features</h3>
            <p class="admin-card-subtitle">System security configuration and status</p>
        </div>
        <div class="admin-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                <div style="padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="margin: 0;">Two-Factor Authentication</h4>
                        <div style="width: 12px; height: 12px; background: #059669; border-radius: 50%;"></div>
                    </div>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">Enabled for all admin accounts</p>
                </div>

                <div style="padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="margin: 0;">SSL/TLS Encryption</h4>
                        <div style="width: 12px; height: 12px; background: #059669; border-radius: 50%;"></div>
                    </div>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">Certificate valid until 2025</p>
                </div>

                <div style="padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="margin: 0;">Firewall Protection</h4>
                        <div style="width: 12px; height: 12px; background: #059669; border-radius: 50%;"></div>
                    </div>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">Active with DDoS protection</p>
                </div>

                <div style="padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="margin: 0;">Data Backup</h4>
                        <div style="width: 12px; height: 12px; background: #059669; border-radius: 50%;"></div>
                    </div>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">Automated daily backups</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Security Events -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Recent Security Events</h3>
            <p class="admin-card-subtitle">Latest security-related activities</p>
        </div>
        <div class="admin-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>User</th>
                        <th>IP Address</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Admin Login</td>
                        <td>karlo</td>
                        <td>192.168.1.100</td>
                        <td>2 mins ago</td>
                        <td><span style="color: #059669;">✓ Success</span></td>
                    </tr>
                    <tr>
                        <td>Failed Login Attempt</td>
                        <td>unknown</td>
                        <td>203.45.67.89</td>
                        <td>15 mins ago</td>
                        <td><span style="color: #dc2626;">✗ Failed</span></td>
                    </tr>
                    <tr>
                        <td>Password Change</td>
                        <td>admin</td>
                        <td>192.168.1.101</td>
                        <td>1 hour ago</td>
                        <td><span style="color: #059669;">✓ Success</span></td>
                    </tr>
                    <tr>
                        <td>Database Backup</td>
                        <td>system</td>
                        <td>localhost</td>
                        <td>2 hours ago</td>
                        <td><span style="color: #059669;">✓ Success</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Close admin layout -->
</div>
</div>
