<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Horizon - Modern Event Management</title>
  <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🌌</text></svg>">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <div class="header-row">
        <a href="<?= BASE_PATH ?>/Index.php" class="brand-link">Event Horizon</a>
        <nav class="main-nav">
          <a href="<?= BASE_PATH ?>/Index.php?controller=user&action=login">Sign In</a>
          <a href="<?= BASE_PATH ?>/Index.php?controller=event&action=index">Browse Events</a>
          <a href="<?= BASE_PATH ?>/Index.php?controller=venue&action=index">Explore Venues</a>
        </nav>
      </div>
    </div>
  </header>
  <main class="container">
