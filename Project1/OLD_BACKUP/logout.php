<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - EventPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div style="font-size: 48px; margin-bottom: 16px;">👋</div>
                <h2>See you later!</h2>
                <p>You have been successfully logged out of EventPro</p>
            </div>
            
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <a href="index.php" class="btn" style="text-decoration: none; flex: 1; text-align: center;">Sign In Again</a>
                <a href="register.php" class="btn btn-secondary" style="text-decoration: none; flex: 1; text-align: center;">Create Account</a>
            </div>
        </div>
    </div>
    
    <script>
        // Auto redirect after 5 seconds
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 5000);
    </script>
</body>
</html>
