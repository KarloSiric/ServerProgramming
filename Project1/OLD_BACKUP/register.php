    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join EventPro and start managing events</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Username already exists or registration failed.</div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo PROJECT_URL; ?>/Index.php?controller=user&action=doRegister">
                <div class="form-group">
                    <input type="text" name="username" class="form-input" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-input" placeholder="Email address" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-input" placeholder="Password" required>
                </div>
                <button type="submit" class="btn">Create Account</button>
            </form>
            
            <p class="text-center mt-20">
                Already have an account? <a href="<?php echo PROJECT_URL; ?>/Index.php?controller=user&action=login" class="link">Sign in</a>
            </p>
        </div>
    </div>
