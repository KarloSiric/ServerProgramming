<!-- landing page with context-aware CTAs -->
<div class="p-5 rounded-3 bg-body-tertiary">
  <h1 class="h3 mb-2">Welcome to EventManager</h1>
  <p class="text-secondary">Browse events, register, and manage your schedule.</p>
  <?php if (empty($_SESSION['user'])): ?>
    <a class="btn btn-primary me-2" href="<?php echo PROJECT_URL; ?>/Index.php?user/login">Login</a>
    <a class="btn btn-outline-primary" href="<?php echo PROJECT_URL; ?>/Index.php?user/register">Register</a>
  <?php else: ?>
    <a class="btn btn-primary me-2" href="<?php echo PROJECT_URL; ?>/Index.php?event/index">View Events</a>
    <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
      <a class="btn btn-outline-secondary" href="<?php echo PROJECT_URL; ?>/Index.php?admin/dashboard">Admin</a>
    <?php endif; ?>
  <?php endif; ?>
</div>
