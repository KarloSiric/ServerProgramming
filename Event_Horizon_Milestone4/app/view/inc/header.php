<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= TITLE ?></title>
  <link rel="stylesheet" href="<?= PROJECT_URL ?>/public/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-row">
    <a href="<?= PROJECT_URL ?>/" class="brand-link">🌟 Event Horizon</a>
    <nav class="main-nav">
      <?php if (isset($_SESSION['user'])): ?>
        <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
          <!-- Admin Navigation -->
          <a href="<?= PROJECT_URL ?>/event/all">Manage Events</a>
          <a href="<?= PROJECT_URL ?>/venue/index">Manage Venues</a>
          <a href="<?= PROJECT_URL ?>/user/logout">Sign Out</a>
        <?php else: ?>
          <!-- Attendee Navigation -->
          <a href="<?= PROJECT_URL ?>/event/all">Browse Events</a>
          <a href="<?= PROJECT_URL ?>/attendee/dashboard">My Dashboard</a>
          <a href="<?= PROJECT_URL ?>/user/logout">Sign Out</a>
        <?php endif; ?>
      <?php else: ?>
        <!-- Guest Navigation -->
        <a href="<?= PROJECT_URL ?>/user/login">Sign In</a>
        <a href="<?= PROJECT_URL ?>/user/register">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
