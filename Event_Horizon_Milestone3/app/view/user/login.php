<div class="login-container">
  <!-- Animated Background -->
  <div class="animated-bg">
    <div class="gradient-circle circle-1"></div>
    <div class="gradient-circle circle-2"></div>
    <div class="gradient-circle circle-3"></div>
  </div>

  <!-- Login Card -->
  <section class="login-card">
    <!-- Logo Section -->
    <div class="logo-section">
      <div class="logo-wrapper">
        <span class="logo-icon">🌌</span>
        <h1 class="logo-text">Event Horizon</h1>
      </div>
      <p class="tagline">Your Gateway to Amazing Events</p>
    </div>

    <!-- Welcome Message -->
    <div class="welcome-section">
      <h2 class="welcome-title">Welcome Back!</h2>
      <p class="welcome-subtitle">Sign in to continue to your dashboard</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert-error animated-alert">
        <span class="alert-icon">⚠️</span>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=user&action=login" class="login-form">
      <div class="form-group">
        <label for="email">
          <span class="label-icon">✉️</span>
          Email Address
        </label>
        <input type="email"
          id="email"
          name="email"
          required
          placeholder="your@email.com"
          autocomplete="email">
        <div class="input-highlight"></div>
      </div>

      <div class="form-group">
        <label for="password">
          <span class="label-icon">🔒</span>
          Password
        </label>
        <input type="password"
          id="password"
          name="password"
          required
          placeholder="Enter your password"
          autocomplete="current-password">
        <div class="input-highlight"></div>
      </div>

      <!-- Remember Me & Forgot Password -->
      <div class="form-options">
        <label class="checkbox-wrapper">
          <input type="checkbox" name="remember" id="remember">
          <span class="checkbox-custom"></span>
          <span class="checkbox-label">Remember me</span>
        </label>
        <a href="#" class="forgot-link" onclick="alert('Password reset feature coming soon!'); return false;">
          Forgot Password?
        </a>
      </div>

      <button type="submit" class="login-button">
        <span class="button-text">Sign In to Event Horizon</span>
        <span class="button-icon">→</span>
      </button>
    </form>

    <!-- Info Cards -->
    <div class="info-cards">
      <div class="info-card admin-card">
        <span class="card-icon">👨‍💼</span>
        <div class="card-content">
          <strong>Administrators</strong>
          <small>Access the Events Dashboard</small>
        </div>
      </div>
      <div class="info-card attendee-card">
        <span class="card-icon">👥</span>
        <div class="card-content">
          <strong>Attendees</strong>
          <small>View your personalized portal</small>
        </div>
      </div>
    </div>

    <!-- Footer Links -->
    <div class="login-footer">
      <p class="footer-text">
        Don't have an account?
        <a href="<?= htmlspecialchars(BASE_PATH) ?>/Index.php?controller=user&action=register" class="register-link">
          Create one now
        </a>
      </p>
    </div>

    <!-- Decorative Elements -->
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration top-right"></div>
    <div class="corner-decoration bottom-left"></div>
    <div class="corner-decoration bottom-right"></div>
  </section>
</div>

<style>
  .login-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
  }

  .animated-bg {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    overflow: hidden;
  }

  .gradient-circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.4;
    animation: floatCircle 15s ease-in-out infinite;
  }

  .circle-1 {
    width: 400px;
    height: 400px;
    background: var(--primary-gradient);
    top: -200px;
    left: -200px;
  }

  .circle-2 {
    width: 300px;
    height: 300px;
    background: var(--secondary-gradient);
    bottom: -150px;
    right: -150px;
    animation-delay: 5s;
  }

  .circle-3 {
    width: 250px;
    height: 250px;
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 10s;
  }

  @keyframes floatCircle {

    0%,
    100% {
      transform: translate(0, 0) scale(1);
    }

    33% {
      transform: translate(30px, -30px) scale(1.1);
    }

    66% {
      transform: translate(-30px, 30px) scale(0.9);
    }
  }

  .login-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 32px;
    padding: 3rem;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    max-width: 500px;
    width: 100%;
    position: relative;
    overflow: hidden;
    animation: cardEntry 0.6s ease-out;
  }

  @keyframes cardEntry {
    from {
      opacity: 0;
      transform: translateY(30px) scale(0.95);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .logo-section {
    text-align: center;
    margin-bottom: 2rem;
  }

  .logo-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
  }

  .logo-icon {
    font-size: 3rem;
    animation: rotate 20s linear infinite;
  }

  @keyframes rotate {
    from {
      transform: rotate(0deg);
    }

    to {
      transform: rotate(360deg);
    }
  }

  .logo-text {
    font-size: 2rem;
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
  }

  .tagline {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin: 0;
  }

  .welcome-section {
    text-align: center;
    margin-bottom: 2rem;
  }

  .welcome-title {
    font-size: 1.75rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
  }

  .welcome-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
  }

  .login-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .form-group {
    position: relative;
  }

  .form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .label-icon {
    font-size: 1rem;
  }

  .form-group input {
    width: 100%;
    padding: 1.25rem 1.5rem;
    border-radius: 16px;
    border: 2px solid var(--border-light);
    background: var(--bg-main);
    color: var(--text-primary);
    outline: none;
    font-size: 1rem;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .form-group input:focus {
    border-color: transparent;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .form-group input:focus+.input-highlight {
    width: 100%;
  }

  .input-highlight {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 0;
    background: var(--primary-gradient);
    transition: width 0.3s ease;
    border-radius: 0 0 16px 16px;
  }

  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0.5rem 0;
  }

  .checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
  }

  .checkbox-wrapper input[type="checkbox"] {
    display: none;
  }

  .checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-light);
    border-radius: 6px;
    transition: all 0.3s ease;
    position: relative;
  }

  .checkbox-wrapper input[type="checkbox"]:checked+.checkbox-custom {
    background: var(--primary-gradient);
    border-color: transparent;
  }

  .checkbox-wrapper input[type="checkbox"]:checked+.checkbox-custom::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 14px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .checkbox-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
  }

  .forgot-link {
    color: var(--accent-purple);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .forgot-link:hover {
    text-decoration: underline;
  }

  .login-button {
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 16px;
    padding: 1.25rem;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    margin-top: 1rem;
  }

  .login-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .login-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
  }

  .login-button:hover::before {
    width: 400px;
    height: 400px;
  }

  .login-button:hover .button-icon {
    transform: translateX(5px);
  }

  .button-text {
    position: relative;
    z-index: 1;
  }

  .button-icon {
    font-size: 1.3rem;
    transition: transform 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .info-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 2rem;
  }

  .info-card {
    padding: 1rem;
    background: var(--bg-main);
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
    border: 2px solid var(--border-light);
  }

  .info-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
  }

  .admin-card:hover {
    border-color: var(--accent-purple);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
  }

  .attendee-card:hover {
    border-color: var(--accent-pink);
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.05) 0%, rgba(245, 87, 108, 0.05) 100%);
  }

  .card-icon {
    font-size: 1.5rem;
  }

  .card-content {
    display: flex;
    flex-direction: column;
  }

  .card-content strong {
    font-size: 0.9rem;
    color: var(--text-primary);
  }

  .card-content small {
    font-size: 0.75rem;
    color: var(--text-secondary);
  }

  .login-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-light);
  }

  .footer-text {
    color: var(--text-secondary);
    font-size: 0.95rem;
  }

  .register-link {
    color: var(--accent-purple);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .register-link:hover {
    text-decoration: underline;
  }

  .animated-alert {
    animation: shakeAlert 0.5s ease-out;
  }

  @keyframes shakeAlert {

    0%,
    100% {
      transform: translateX(0);
    }

    10%,
    30%,
    50%,
    70%,
    90% {
      transform: translateX(-5px);
    }

    20%,
    40%,
    60%,
    80% {
      transform: translateX(5px);
    }
  }

  .corner-decoration {
    position: absolute;
    width: 80px;
    height: 80px;
    opacity: 0.05;
  }

  .top-left {
    top: 0;
    left: 0;
    background: var(--primary-gradient);
    border-radius: 0 0 100% 0;
  }

  .top-right {
    top: 0;
    right: 0;
    background: var(--secondary-gradient);
    border-radius: 0 0 0 100%;
  }

  .bottom-left {
    bottom: 0;
    left: 0;
    background: var(--secondary-gradient);
    border-radius: 0 100% 0 0;
  }

  .bottom-right {
    bottom: 0;
    right: 0;
    background: var(--primary-gradient);
    border-radius: 100% 0 0 0;
  }

  @media (max-width: 768px) {
    .login-card {
      padding: 2rem;
    }

    .info-cards {
      grid-template-columns: 1fr;
    }

    .form-options {
      flex-direction: column;
      gap: 1rem;
      align-items: stretch;
    }
  }
</style>
