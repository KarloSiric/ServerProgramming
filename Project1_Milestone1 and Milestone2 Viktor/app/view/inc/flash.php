<?php
// one-time messages pulled from session and then cleared
if (!empty($_SESSION['flash'])): ?>
  <?php foreach ($_SESSION['flash'] as $type => $messages): ?>
    <?php foreach ((array)$messages as $m): ?>
      <div class="alert alert-<?= htmlspecialchars($type) ?> mb-3"><?= htmlspecialchars($m) ?></div>
    <?php endforeach; ?>
  <?php endforeach; unset($_SESSION['flash']); ?>
<?php endif; ?>
