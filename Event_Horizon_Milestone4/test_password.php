<?php
// Quick password test script
define('CONFIG_PATH', __DIR__ . '/config');
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

// Get all users with their passwords
$stmt = $db->query("SELECT username, password FROM attendee LIMIT 10");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Users in Database:</h2>";
foreach ($users as $user) {
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "<br>";
    echo "<strong>Password Hash:</strong> " . htmlspecialchars(substr($user['password'], 0, 30)) . "...<br>";
    
    // Test if password is 'password'
    if (password_verify('password', $user['password'])) {
        echo "<span style='color:green'>✓ Password is: 'password'</span><br>";
    } else {
        echo "<span style='color:red'>✗ Password is NOT 'password'</span><br>";
    }
    echo "</p><hr>";
}

// Create a new test user with known password
echo "<h2>Creating test user...</h2>";
try {
    $testHash = password_hash('test123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO attendee (first_name, last_name, email, username, password, role_id) 
                         VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Test', 'User', 'test@example.com', 'testuser', $testHash, 1]);
    echo "<p style='color:green'>✓ Created user: <strong>testuser</strong> / <strong>test123</strong> (admin)</p>";
} catch (Exception $e) {
    echo "<p style='color:orange'>User might already exist or: " . $e->getMessage() . "</p>";
}
