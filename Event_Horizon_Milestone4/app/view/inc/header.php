<?php
// Ensure BASE_PATH/PROJECT_URL exist
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
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= htmlspecialchars(PROJECT_TITLE ?? 'Event Horizon') ?></title>
  <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-row">
    <a href="<?= BASE_PATH ?>/index.php" class="brand-link">Event Horizon</a>
    <nav class="main-nav">
      <a href="<?= BASE_PATH ?>/index.php?controller=user&action=login">Sign In</a>
      <a href="<?= BASE_PATH ?>/index.php?controller=event&action=index">Browse Events</a>
      <a href="<?= BASE_PATH ?>/index.php?controller=venue&action=index">Explore Venues</a>
    </nav>
  </div>
</header>
<main class="container">
