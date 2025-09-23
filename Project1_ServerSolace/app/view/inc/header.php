<?php
$title = $title ?? 'EventHorizon';
$user = $user ?? null;
$isAdmin = ($user['role'] ?? '') === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/~ks9700/iste-341/Project1/public/css/style.css">
    <?php if ($isAdmin): ?>
    <link rel="stylesheet" href="/~ks9700/iste-341/Project1/public/css/admin.css">
    <?php endif; ?>
</head>
<body>
    <?php if ($user && $isAdmin): ?>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <a href="?admin/overview" class="sidebar-brand">
                    <div class="logo" style="background-image: url('/~ks9700/iste-341/Project1/public/img/Project1_LogoImage.png');"></div>
                    <div class="brand-text">
                        <h2>EventHorizon</h2>
                        <p>Admin Console</p>
                    </div>
                </a>
            </div>
            
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar-admin"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                    <div class="user-details">
                        <h4><?= htmlspecialchars($user['name']) ?></h4>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    <div class="user-badge">Admin</div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">System metrics & insights</div>
                    <a href="?admin/overview" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/overview') !== false ? 'active' : '' ?>">
                        <span class="icon">📊</span>
                        <span class="text">Overview</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <a href="?admin/events" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/events') !== false ? 'active' : '' ?}">
                        <span class="icon">📅</span>
                        <span class="text">Event Management</span>
                    </a>
                    <a href="?admin/analytics" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/analytics') !== false ? 'active' : '' ?>">
                        <span class="icon">📈</span>
                        <span class="text">Analytics</span>
                    </a>
                    <a href="?admin/users" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/users') !== false ? 'active' : '' ?>">
                        <span class="icon">👥</span>
                        <span class="text">User Management</span>
                    </a>
                    <a href="?admin/database" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/database') !== false ? 'active' : '' ?>">
                        <span class="icon">🗄️</span>
                        <span class="text">Data Console</span>
                    </a>
                    <a href="?admin/performance" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/performance') !== false ? 'active' : '' ?}">
                        <span class="icon">⚡</span>
                        <span class="text">Performance</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">System</div>
                    <a href="?admin/security" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/security') !== false ? 'active' : '' ?}">
                        <span class="icon">🔒</span>
                        <span class="text">Security</span>
                    </a>
                    <a href="?admin/reports" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/reports') !== false ? 'active' : '' ?}">
                        <span class="icon">📋</span>
                        <span class="text">Reports</span>
                    </a>
                    <a href="?admin/notifications" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/notifications') !== false ? 'active' : '' ?}">
                        <span class="icon">🔔</span>
                        <span class="text">Notifications</span>
                    </a>
                    <a href="?admin/settings" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'admin/settings') !== false ? 'active' : '' ?}">
                        <span class="icon">⚙️</span>
                        <span class="text">Settings</span>
                    </a>
                </div>
            </nav>
            
            <div class="system-status">
                <div class="status-indicator">
                    <div class="status-dot"></div>
                    <span>System Online</span>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-navbar">
                <div class="admin-nav-left">
                    <div>
                        <span class="icon">📅</span>
                        <a href="?user/dashboard" style="color: #64748b; text-decoration: none; margin-left: 8px;">Events</a>
                    </div>
                    <div style="margin-left: 16px;">
                        <span class="icon">⚙️</span>
                        <span style="color: #64748b; margin-left: 8px;">Manage</span>
                    </div>
                    <div style="margin-left: 16px;">
                        <span class="icon">👥</span>
                        <a href="?user/attendees" style="color: #64748b; text-decoration: none; margin-left: 8px;">Attendees</a>
                    </div>
                </div>
                <div class="admin-nav-right">
                    <span style="color: #64748b; font-weight: 500;">Admin</span>
                    <div class="user-avatar-admin" style="width: 24px; height: 24px; font-size: 12px;">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <a href="?user/logout" class="btn-admin btn-admin-outline" style="padding: 6px 12px;">
                        <span>🚪</span> Logout
                    </a>
                </div>
            </div>
    <?php elseif ($user): ?>
        <!-- Regular user navbar -->
        <nav class="navbar">
            <div class="nav-container">
                <a href="?user/dashboard" class="nav-brand">
                    <div class="logo" style="background-image: url('/~ks9700/iste-341/Project1/public/img/Project1_LogoImage.png');"></div>
                    <div class="nav-brand-text">
                        <h1>EventHorizon</h1>
                        <p>Beyond the Edge of Events</p>
                    </div>
                </a>
                
                <ul class="nav-links">
                    <li><a href="?user/dashboard">
                        <span class="icon">📅</span> Events
                    </a></li>
                    <li><a href="?user/attendees">
                        <span class="icon">👥</span> Attendees  
                    </a></li>
                </ul>
                
                <div class="nav-user">
                    <div class="user-avatar"><?= strtoupper(substr($user['username'], 0, 2)) ?></div>
                    <a href="?user/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>
