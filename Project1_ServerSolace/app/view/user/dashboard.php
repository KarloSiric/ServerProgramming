<!DOCTYPE html>
<html>
<head>
    <title>System Test - EventHorizon</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f8f9fa; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; color: #155724; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; padding: 20px; border-radius: 8px; color: #0c5460; }
    </style>
</head>
<body>
    <h1>EventHorizon System Test</h1>
    <div class="success">
        <h3>✅ System is Loading!</h3>
        <p>If you can see this page, the new architecture is working. The bootstrap system successfully loaded, the router was found, and the controller system is operational.</p>
    </div>
    
    <div class="info">
        <h3>Test Your System</h3>
        <p>Try these links to test the new routing:</p>
        <ul>
            <li><a href="?user/login">User Login</a> → should load app/view/user/login.php</li>
            <li><a href="?user/register">User Registration</a> → should load app/view/user/register.php</li>
            <li><a href="?admin/overview">Admin Dashboard</a> → should load app/view/admin/overview.php</li>
            <li><a href="?admin/events">Admin Events</a> → should load app/view/admin/events.php</li>
        </ul>
    </div>
    
    <h3>System Information</h3>
    <p><strong>Current URL:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'undefined' ?></p>
    <p><strong>Query String:</strong> <?= $_SERVER['QUERY_STRING'] ?? 'none' ?></p>
    <p><strong>Project URL:</strong> <?= PROJECT_URL ?? 'not defined' ?></p>
</body>
</html>
