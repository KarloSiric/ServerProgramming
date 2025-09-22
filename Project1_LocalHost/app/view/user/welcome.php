    <div class="main-content">
        <div class="content-card">
            <?php if ($data['role'] === 'admin'): ?>
                <!-- ADMIN VIEW -->
                <h1>🔐 ADMIN DASHBOARD</h1>
                <h2>Welcome, Administrator <?php echo htmlspecialchars($data['username']); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($data['email']); ?></p>
                
                <div class="admin-panel" style="margin-top: 30px; padding: 20px; background: #f3f4f6; border-radius: 10px;">
                    <h3>Admin Controls</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin: 10px 0;">✓ Manage Users</li>
                        <li style="margin: 10px 0;">✓ System Settings</li>
                        <li style="margin: 10px 0;">✓ View Reports</li>
                        <li style="margin: 10px 0;">✓ Access Logs</li>
                    </ul>
                </div>
                
            <?php elseif ($data['role'] === 'teacher'): ?>
                <!-- TEACHER VIEW -->
                <h1>📚 TEACHER DASHBOARD</h1>
                <h2>Welcome, Professor <?php echo htmlspecialchars($data['username']); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($data['email']); ?></p>
                
                <div class="teacher-panel" style="margin-top: 30px; padding: 20px; background: #e0f2fe; border-radius: 10px;">
                    <h3>Teacher Tools</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin: 10px 0;">✓ Manage Courses</li>
                        <li style="margin: 10px 0;">✓ Grade Assignments</li>
                        <li style="margin: 10px 0;">✓ Student Progress</li>
                    </ul>
                </div>
                
            <?php else: ?>
                <!-- STUDENT VIEW -->
                <h1>🎓 STUDENT DASHBOARD</h1>
                <h2>Welcome, <?php echo htmlspecialchars($data['username']); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($data['email']); ?></p>
                
                <div class="student-panel" style="margin-top: 30px; padding: 20px; background: #f0fdf4; border-radius: 10px;">
                    <h3>Student Resources</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin: 10px 0;">✓ View Courses</li>
                        <li style="margin: 10px 0;">✓ Submit Assignments</li>
                        <li style="margin: 10px 0;">✓ Check Grades</li>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 30px;">
                <a href="<?php echo PROJECT_URL; ?>" class="btn">Logout</a>
            </div>
        </div>
    </div>
