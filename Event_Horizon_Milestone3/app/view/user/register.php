<section class="card" style="max-width: 600px;">
  <h2>Create Account</h2>
  <?php if (!empty($error)): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form class="form" method="post" action="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=user&action=register">
    <label>First Name
      <input name="first_name" required>
    </label>
    <label>Last Name
      <input name="last_name" required>
    </label>
    <label>Email
      <input type="email" name="email" required>
    </label>
    <label>Username
      <input name="username" required>
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button>Create Account</button>
  </form>
  <p class="hint">Already have an account? <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=user&action=login">Sign in</a></p>
</section>
