<?php
// Debug login script
define('CONFIG_PATH', __DIR__ . '/config');
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

echo "<h2>Testing Authentication</h2>";

$username = 'simpleadmin';
$password = 'password';

echo "<p>Testing with username: <strong>$username</strong> and password: <strong>$password</strong></p>";

// Query the database
$sql = "SELECT a.attendee_id, a.username, a.email, a.password, r.name AS role_name
        FROM attendee a
        JOIN role r ON r.role_id = a.role_id
        WHERE a.username = :un LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute([':un' => $username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p style='color:red;'>❌ User not found in database!</p>";
    exit;
}

echo "<h3>User found:</h3>";
echo "<pre>";
print_r($row);
echo "</pre>";

echo "<h3>Password verification:</h3>";
echo "<p>Stored hash: " . htmlspecialchars($row['password']) . "</p>";
echo "<p>Testing password: $password</p>";

if (password_verify($password, $row['password'])) {
    echo "<p style='color:green;font-size:20px;'>✓ PASSWORD MATCHES! Authentication should work!</p>";
    echo "<p>Role: " . $row['role_name'] . "</p>";
} else {
    echo "<p style='color:red;font-size:20px;'>❌ PASSWORD DOES NOT MATCH!</p>";
    echo "<p>The hash in the database is wrong. Need to update it.</p>";
}
