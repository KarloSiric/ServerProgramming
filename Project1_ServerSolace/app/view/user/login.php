<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div style="display: flex; align-items: center; gap: 12px; justify-content: center; margin-bottom: 24px;">
                <div class="logo" style="background-image: url('public/img/Project1_LogoImage.png'); background-size: cover; background-position: center; width: 48px; height: 48px; border-radius: 12px;"></div>
                <div>
                    <h1 style="font-size: 24px; font-weight: 600; margin: 0;">EventHorizon</h1>
                    <p style="margin: 0; font-size: 14px; color: #64748b;">Beyond the Edge of Events</p>
                </div>
            </div>
            <h2 style="margin-bottom: 8px; font-size: 28px; font-weight: 600;">Welcome Back</h2>
            <p style="color: #64748b; font-size: 16px;">Sign in to your EventHub account to manage<br>your tech conference experience</p>
        </div>

        <?php if (!empty($error)): ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="?user/authenticate">
            <div class="form-group">
                <label for="username" class="form-label" style="font-size: 14px; font-weight: 500;">Email</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">📧</span>
                    <input type="text" id="username" name="username" class="form-control" 
                           style="padding-left: 40px; height: 48px; font-size: 16px;" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label" style="font-size: 14px; font-weight: 500;">Password</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">🔒</span>
                    <input type="password" id="password" name="password" class="form-control" 
                           style="padding-left: 40px; padding-right: 40px; height: 48px; font-size: 16px;" placeholder="Enter your password" required>
                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; cursor: pointer;">👁️</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; padding: 12px; margin-bottom: 24px; font-size: 16px; font-weight: 600;">
                Sign In
            </button>
        </form>

        <div style="text-align: center; color: #64748b; font-size: 14px;">
            Don't have an account? <a href="?user/register" style="color: #4f46e5; text-decoration: underline;">Create account</a>
        </div>
    </div>
</div>
