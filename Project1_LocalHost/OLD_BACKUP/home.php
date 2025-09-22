<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EventPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">EventPro</div>
            <ul class="nav-links">
                <li><a href="home.php" class="active">Dashboard</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="venues.php">Venues</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <div class="content-card">
            <h1 class="page-title">Welcome back, <?php echo htmlspecialchars($user['username']); ?>! ✨</h1>
            <p class="page-subtitle">Here's what's happening with your events today</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <span class="stat-number">8</span>
                    <div class="stat-label">Active Events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <span class="stat-number">5</span>
                    <div class="stat-label">Venues</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <span class="stat-number">247</span>
                    <div class="stat-label">Attendees</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <span class="stat-number">4.8</span>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <a href="events.php" class="btn" style="text-decoration: none; text-align: center; display: block;">📝 Manage Events</a>
                <a href="venues.php" class="btn" style="text-decoration: none; text-align: center; display: block; background: linear-gradient(135deg, #06b6d4, #8b5cf6);">🏢 View Venues</a>
            </div>
        </div>
    </div>
</body>
</html>
