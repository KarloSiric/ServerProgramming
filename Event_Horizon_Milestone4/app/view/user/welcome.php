<div class="card" style="max-width: 600px; margin: 4rem auto; text-align: center;">
  <h2 style="font-size: 2.5rem; margin-bottom: 2rem;">🎉 Welcome to Event Horizon!</h2>
  <p style="font-size: 1.25rem; color: var(--text-secondary); margin-bottom: 2rem;">
    Hello, <span style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
      <?= htmlspecialchars($_SESSION['user']['username'] ?? 'friend') ?>
    </span>!
  </p>
  <p style="margin-bottom: 2rem; color: var(--text-secondary);">You're successfully logged in. Ready to explore?</p>
  <a href="<?= htmlspecialchars(BASE_PATH) ?>/index.php?controller=user&action=dashboard"
     style="display:inline-block;padding:1rem 2rem;background:var(--primary-gradient);color:white;text-decoration:none;border-radius:50px;font-weight:700;font-size:1.1rem;box-shadow:var(--shadow-md);transition:all .3s;">
    🚀 Launch Your Dashboard
  </a>
</div>
