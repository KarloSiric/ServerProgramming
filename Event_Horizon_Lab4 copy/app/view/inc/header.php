<?php
// Ensure BASE_PATH and PROJECT_URL exist even if Index didn't run yet.
if (!defined('BASE_PATH')) {
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    define('BASE_PATH', $scriptDir === '' ? '' : $scriptDir);
}
if (!defined('PROJECT_URL')) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    define('PROJECT_URL', $scheme . '://' . $host . BASE_PATH);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Horizon - Modern Event Management</title>
  <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml...ox='0 0 100 100'><text y='0.9em' font-size='90'>🌌</text></svg>">
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
