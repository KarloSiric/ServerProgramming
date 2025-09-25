<?php
/**
 * @file header.php
 * @brief Main layout header included in all pages
 * 
 * This file is included at the start of every page render.
 * Sets up session, loads demo data, and creates the HTML header.
 * Provides different layouts for admin vs regular users.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Included by Controller::view() method
 * @see Controller::view()
 */

/**
 * Initialize session if not already started
 * Required for user authentication and flash messages
 */
if (session_status() === PHP_SESSION_NONE) session_start();

/**
 * @brief Flash message helper function
 * 
 * Stores one-time messages in session for display
 * Messages are automatically cleared after display
 * 
 * @param string $type Message type (success, danger, warning, info)
 * @param string $msg Message content
 * @return void
 * 
 * @note Messages displayed by flash.php include
 * @see app/view/inc/flash.php
 */
function flash($type, $msg) { 
    $_SESSION['flash'][$type][] = $msg; 
}

/**
 * Load demo data from AppModel
 * This data is available to ALL views as variables
 */
$m = new AppModel();
$venues        = $m->venues();         // All venue records
$events        = $m->events();         // All event records  
$registrations = $m->registrations();  // All registration records
$users         = $m->users();          // All user records

/**
 * Page-specific variables
 * These are used throughout views for context
 */
$user = $_SESSION['user'] ?? null;                    // Current logged-in user
$title = $title ?? 'EventHorizon';                    // Page title (can be overridden)
$isAdmin = ($user['role'] ?? '') === 'admin';         // Quick admin check flag

/**
 * Begin HTML output
 * Uses Bootstrap 5.3 for styling
 */
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'EventHorizon') ?></title>
    
    <!-- Bootstrap CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom application styles -->
    <link rel="stylesheet" href="<?= PROJECT_URL; ?>/public/css/style.css">
    
    <?php if ($isAdmin): ?>
        <!-- Additional admin-specific styles -->
        <link rel="stylesheet" href="<?= PROJECT_URL; ?>/public/css/admin.css">
    <?php endif; ?>
    
    <!-- Inline styles for sticky footer layout -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Main content expands to fill space */
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <?php 
    /**
     * Admin Layout
     * Special sidebar layout for admin users
     */
    if ($user && $isAdmin): 
    ?>
    <div class="admin-layout">
        <!-- Admin Sidebar Navigation -->
        <div class="admin-sidebar">
            <!-- Sidebar Header with Logo -->
            <div class="sidebar-header">
                <a href="?admin/overview" class="sidebar-brand">
                    <div class="logo" style="background-image: url('<?= PROJECT_URL; ?>/public/img/Project1_LogoImage.png'); background-size: cover; background-position: center; width: 48px; height: 48px; border-radius: 8px;"></div>
                    <div class="brand-text">
                        <h2>EventHorizon</h2>
                        <p>Admin Console</p>
                    </div>
                </a>
            </div>
            
            <!-- User Info Section -->
            <div class="sidebar-user">
                <div class="user-info">
                    <!-- User Avatar (shows first letter of username) -->
                    <div class="user-avatar-admin"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                    <div class="user-details">
                        <h4><?= htmlspecialchars($user['name']) ?></h4>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    <div class="user-badge">Admin</div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="sidebar-nav">
                <!-- Dashboard Section -->
                <div class="nav-section">
                    <div class="nav-section-title">System metrics & insights</div>
                    <a href="?admin/overview" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/overview') !== false ? 'active' : '' ?>">
                        <span class="icon">📊</span>
                        <span class="text">Overview</span>
                    </a>
                </div>
                
                <!-- Management Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <a href="?admin/events" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/events') !== false ? 'active' : '' ?>">
                        <span class="icon">📅</span>
                        <span class="text">Event Management</span>
                    </a>
                    <a href="?admin/analytics" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/analytics') !== false ? 'active' : '' ?>">
                        <span class="icon">📈</span>
                        <span class="text">Analytics</span>
                    </a>
                    <a href="?admin/users" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' ?>">
                        <span class="icon">👥</span>
                        <span class="text">User Management</span>
                    </a>
                    <a href="?admin/reports" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false ? 'active' : '' ?>">
                        <span class="icon">📄</span>
                        <span class="text">Reports</span>
                    </a>
                </div>
                
                <!-- System Section -->
                <div class="nav-section">
                    <div class="nav-section-title">System</div>
                    <a href="?admin/settings" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : '' ?>">
                        <span class="icon">⚙️</span>
                        <span class="text">Settings</span>
                    </a>
                    <a href="?admin/security" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/security') !== false ? 'active' : '' ?>">
                        <span class="icon">🔒</span>
                        <span class="text">Security</span>
                    </a>
                    <a href="?admin/database" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/database') !== false ? 'active' : '' ?>">
                        <span class="icon">🗄️</span>
                        <span class="text">Database</span>
                    </a>
                    <a href="?admin/performance" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/performance') !== false ? 'active' : '' ?>">
                        <span class="icon">⚡</span>
                        <span class="text">Performance</span>
                    </a>
                    <a href="?admin/notifications" class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/notifications') !== false ? 'active' : '' ?>">
                        <span class="icon">🔔</span>
                        <span class="text">Notifications</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
    
    <?php 
    /**
     * Regular User Navigation
     * Standard top navigation bar for non-admin users
     */
    elseif ($user): 
    ?>
        <nav class="navbar">
            <div class="nav-content">
                <!-- Logo and Brand -->
                <a href="?user/dashboard" class="nav-brand">
                    <div class="logo-circle">
                        <span class="logo-text">EH</span>
                    </div>
                    <div>
                        <div class="brand-name">EventHorizon</div>
                        <div class="brand-tagline">Beyond the Edge of Events</div>
                    </div>
                </a>
                
                <!-- Main Navigation Links -->
                <ul class="nav-links">
                    <li><a href="?user/dashboard">
                        <span class="icon">📅</span> Events
                    </a></li>
                    <li><a href="?user/attendees">
                        <span class="icon">👥</span> Attendees  
                    </a></li>
                </ul>
                
                <!-- User Menu -->
                <div class="nav-user">
                    <div class="user-avatar"><?= strtoupper(substr($user['username'], 0, 2)) ?></div>
                    <a href="?user/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    
    <!-- Main content wrapper - opened here, closed in footer.php -->
    <main class="flex-shrink-0">
