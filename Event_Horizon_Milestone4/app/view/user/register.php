<section class="card" style="max-width: 600px;">
  <h2>Create Account</h2>
  <?php if (!empty($error)): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  
  <form class="form" method="post" action="<?= PROJECT_URL ?>/user/register">
    <label>First Name
      <input name="first_name" required value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
    </label>
    <label>Last Name
      <input name="last_name" required value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
    </label>
    <label>Email
      <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </label>
    <label>Username
      <input name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <!-- Hidden field: all new users are attendees -->
    <input type="hidden" name="role_id" value="2">
    
    <button type="submit">Create Account</button>
  </form>
  <p class="hint">Already have an account? <a href="<?= PROJECT_URL ?>/user/login">Sign in</a></p>
</section>
