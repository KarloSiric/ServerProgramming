<?php
$eventModel = new EventModel();
$userModel = new UserModel();
$eventStats = $eventModel->getEventStats();
$userStats = $userModel->getUserStats();
?>

<div class="admin-content">
    <div class="admin-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="icon">📈</span>
                <span style="margin-left: 8px; font-size: 16px; color: #64748b;">Analytics</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="btn-admin btn-admin-primary">
                    <span>📊</span> Export Report
                </button>
                <span>🔔</span>
                <span>⚙️</span>
            </div>
        </div>
        <h1>Advanced Analytics</h1>
        <p>Deep insights into platform performance</p>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Total Revenue</div>
                <div class="stat-icon">💰</div>
            </div>
            <div class="stat-value">$206,363</div>
            <div class="stat-change positive">📈 +12.5% from last month</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Registrations</div>
                <div class="stat-icon">👥</div>
            </div>
            <div class="stat-value">704</div>
            <div class="stat-change positive">📈 +8.2% from last month</div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Fill Rate</div>
                <div class="stat-icon">📊</div>
            </div>
            <div class="stat-value">74%</div>
            <div class="progress-bar-admin">
                <div class="progress-fill-admin" style="width: 74%;"></div>
            </div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-header">
                <div class="stat-title">Active Events</div>
                <div class="stat-icon">📅</div>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-change">0 at capacity</div>
        </div>
    </div>

    <!-- Analytics Grid -->
    <div class="metrics-grid">
        <!-- System Performance -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">📈 System Performance</h3>
                    <p class="admin-card-subtitle">Real-time application metrics</p>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="metric-item">
                    <div class="metric-label">API Response Time</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-value">45ms</div>
                        <div class="metric-badge excellent">excellent</div>
                    </div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Database Performance</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-value">99.9%</div>
                        <div class="metric-badge excellent">excellent</div>
                    </div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Error Rate</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-value">0.01%</div>
                        <div class="metric-badge excellent">excellent</div>
                    </div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Active Sessions</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="metric-value">1,247</div>
                        <div class="metric-badge good">good</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Insights -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">🗄️ Data Insights</h3>
                    <p class="admin-card-subtitle">Database and storage metrics</p>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="metric-item">
                    <div class="metric-label">Database Size</div>
                    <div class="metric-value">2.4 GB</div>
                </div>
                <div style="margin: 8px 0;">
                    <div class="progress-bar-admin">
                        <div class="progress-fill-admin" style="width: 24%;"></div>
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">24% of allocated storage</div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Query Performance</div>
                    <div class="metric-value">98.7%</div>
                </div>
                <div style="margin: 8px 0;">
                    <div class="progress-bar-admin">
                        <div class="progress-fill-admin" style="width: 98.7%;"></div>
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Avg query time: 12ms</div>
                </div>
                <div class="metric-item">
                    <div class="metric-label">Cache Hit Rate</div>
                    <div class="metric-value">99.2%</div>
                </div>
                <div style="margin: 8px 0;">
                    <div class="progress-bar-admin">
                        <div class="progress-fill-admin" style="width: 99.2%;"></div>
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Redis cache performance</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Category Performance -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Event Category Performance</h3>
            <p class="admin-card-subtitle">Revenue and registration breakdown by category</p>
        </div>
        <div class="admin-card-body">
            <div class="metric-item">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                    <div class="metric-label">Conference</div>
                    <div style="flex: 1;">
                        <div class="progress-bar-admin">
                            <div class="progress-fill-admin" style="width: 85%; background: #3b82f6;"></div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; align-items: end;">
                    <div class="metric-value">$200,013</div>
                    <div style="font-size: 12px; color: #64748b;">587 registrations</div>
                </div>
            </div>
            
            <div class="metric-item">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                    <div class="metric-label">Workshop</div>
                    <div style="flex: 1;">
                        <div class="progress-bar-admin">
                            <div class="progress-fill-admin" style="width: 15%; background: #3b82f6;"></div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; align-items: end;">
                    <div class="metric-value">$6,350</div>
                    <div style="font-size: 12px; color: #64748b;">50 registrations</div>
                </div>
            </div>
            
            <div class="metric-item">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                    <div class="metric-label">Networking</div>
                    <div style="flex: 1;">
                        <div class="progress-bar-admin">
                            <div class="progress-fill-admin" style="width: 0%; background: #3b82f6;"></div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; align-items: end;">
                    <div class="metric-value">$0</div>
                    <div style="font-size: 12px; color: #64748b;">67 registrations</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Close admin layout -->
</div>
</div>
