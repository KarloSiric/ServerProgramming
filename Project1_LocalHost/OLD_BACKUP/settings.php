    <div class="main-content">
        <div class="content-card">
            <h1 class="page-title">Account Settings</h1>
            <p class="page-subtitle">Manage your account preferences and information</p>
            
            <div class="user-info">
                <div class="user-info-item">
                    <span class="user-info-label">Username</span>
                    <span class="user-info-value"><?php echo htmlspecialchars($data['user']['username']); ?></span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Full Name</span>
                    <span class="user-info-value"><?php echo htmlspecialchars($data['user']['fullname']); ?></span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Role</span>
                    <span class="user-info-value"><?php echo ucfirst($data['user']['role']); ?></span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Email</span>
                    <span class="user-info-value"><?php echo htmlspecialchars($data['user']['email']); ?></span>
                </div>
            </div>
        </div>
        
        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Account Actions</h3>
            <div class="action-grid">
                <a href="#" class="action-btn">🔑 Change Password</a>
                <a href="#" class="action-btn">📝 Update Profile</a>
                <a href="#" class="action-btn">🔔 Notifications</a>
                <a href="#" class="action-btn">🌙 Dark Mode</a>
            </div>
        </div>
        
        <?php if ($data['user']['role'] === 'organizer'): ?>
        <div class="content-card">
            <h3 style="color: var(--gray-900); margin-bottom: 20px;">Organizer Settings</h3>
            <div class="action-grid">
                <a href="#" class="action-btn">📊 Event Analytics</a>
                <a href="#" class="action-btn">💰 Payment Settings</a>
                <a href="#" class="action-btn">📧 Email Templates</a>
                <a href="#" class="action-btn">🎨 Branding</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
