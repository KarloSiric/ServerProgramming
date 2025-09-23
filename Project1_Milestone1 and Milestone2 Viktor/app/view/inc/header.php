<?php
// session + minimal helpers + demo data (no DB yet)
if (session_status() === PHP_SESSION_NONE) session_start();

/** tiny flash helper */
function flash($type, $msg) { $_SESSION['flash'][$type][] = $msg; }

/** provide demo data to views via the model (no DB yet) */
$m = new AppModel();
$venues        = $m->venues();
$events        = $m->events();
$registrations = $m->registrations();
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= htmlspecialchars($title ?? 'Event Manager') ?></title>

  <!-- bootstrap + your css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= PROJECT_URL; ?>/assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-dark-subtle">
<nav class="navbar navbar-expand-lg border-bottom">
  <div class="container">
    <a class="navbar-brand" href="<?= PROJECT_URL; ?>/Index.php">EventManager</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROJECT_URL; ?>/Index.php?event/index">All Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= PROJECT_URL; ?>/Index.php?user/myregistrations">My Registrations</a>
          </li>
          <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= PROJECT_URL; ?>/Index.php?admin/dashboard">Admin</a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if (empty($_SESSION['user'])): ?>
          <li class="nav-item me-2">
            <a class="btn btn-outline-primary" href="<?= PROJECT_URL; ?>/Index.php?user/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary" href="<?= PROJECT_URL; ?>/Index.php?user/register">Register</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <span class="navbar-text me-3 small">
              <?= htmlspecialchars(($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')) ?>
              (<?= htmlspecialchars($_SESSION['user']['role'] ?? '') ?>)
            </span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-danger" href="<?= PROJECT_URL; ?>/Index.php?user/logout">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
