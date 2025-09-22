<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div style="display: flex; align-items: center; gap: 12px; justify-content: center; margin-bottom: 16px;">
                <div class="logo" style="background-image: url('/~ks9700/iste-341/Project1/img/Project1_LogoImage.png'); background-size: cover; background-position: center; width: 32px; height: 32px; border-radius: 8px; background-color: #3b82f6;"></div>
                <div>
                    <h1>EventHorizon</h1>
                    <p style="margin: 0;">Beyond the Edge of Events</p>
                </div>
            </div>
            <h2 style="margin-bottom: 8px;">Create Account</h2>
            <p>Join EventHub to discover and manage professional tech conferences</p>
        </div>

        <?php if (!empty($error)): ?>
            <div style="background: #fee; border: 1px solid #fcc; color: #900; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div style="background: #efe; border: 1px solid #cfc; color: #060; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/~ks9700/iste-341/Project1/user/createAccount">
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm your password" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Account Type</label>
                <select id="role" name="role" class="form-control">
                    <option value="user">Regular User</option>
                    <option value="admin">Event Administrator</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; margin-bottom: 20px;">
                Create Account
            </button>
        </form>

        <div style="text-align: center; color: #6b7280;">
            Already have an account? <a href="/~ks9700/iste-341/Project1/user/login" style="color: #4f46e5;">Sign in</a>
        </div>
    </div>
</div>
