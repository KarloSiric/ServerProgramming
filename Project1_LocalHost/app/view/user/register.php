<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div style="display: flex; align-items: center; gap: 12px; justify-content: center; margin-bottom: 16px;">
                <div class="logo" style="background-image: url('public/img/Project1_LogoImage.png'); background-size: cover; background-position: center; width: 32px; height: 32px; border-radius: 8px;"></div>
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

        <form method="post" action="?user/createAccount">
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;">👤</span>
                    <input type="text" id="name" name="name" class="form-control" 
                           style="padding-left: 40px;" placeholder="Enter your full name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;">📧</span>
                    <input type="email" id="email" name="email" class="form-control" 
                           style="padding-left: 40px;" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;">🔒</span>
                    <input type="password" id="password" name="password" class="form-control" 
                           style="padding-left: 40px;" placeholder="Create a password" required>
                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; cursor: pointer;">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;">🔒</span>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                           style="padding-left: 40px;" placeholder="Confirm your password" required>
                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; cursor: pointer;">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="admin_role" style="margin: 0;">
                    <span>Register as Event Administrator</span>
                </label>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" required style="margin: 0;">
                    <span>I agree to the Terms of Service and Privacy Policy</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; margin-bottom: 20px;">
                Create Account
            </button>
        </form>

        <div style="text-align: center; color: #6b7280;">
            Already have an account? <a href="?user/login" style="color: #4f46e5;">Sign in</a>
        </div>
    </div>
</div>
