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
    <!-- Admin layout stays the same for now -->
    <?php elseif ($user): ?>
        <nav class="navbar">
            <div class="nav-container">
                <a href="/~ks9700/iste-341/Project1/user/dashboard" class="nav-brand">
                    <div class="logo" style="background-image: url('/~ks9700/iste-341/Project1/img/Project1_LogoImage.png');"></div>
                    <div class="nav-brand-text">
                        <h1>EventHorizon</h1>
                        <p>Beyond the Edge of Events</p>
                    </div>
                </a>
                
                <ul class="nav-links">
                    <li><a href="/~ks9700/iste-341/Project1/user/dashboard">Events</a></li>
                    <li><a href="/~ks9700/iste-341/Project1/user/attendees">Attendees</a></li>
                </ul>
                
                <div class="nav-user">
                    <div class="user-avatar"><?= strtoupper(substr($user['username'], 0, 2)) ?></div>
                    <a href="/~ks9700/iste-341/Project1/user/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>
