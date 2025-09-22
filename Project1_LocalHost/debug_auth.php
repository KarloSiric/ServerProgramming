<?php
require_once 'app/model/Model.php';
require_once 'app/model/UserModel.php';

echo "<h1>Login Debug</h1>";

try {
    $userModel = new UserModel();
    
    // Check what users exist
    echo "<h2>Users in Database:</h2>";
    $users = $userModel->getAllUsers();
    echo "Found " . count($users) . " users:<br>";
    foreach ($users as $user) {
        echo "Username: '{$user['username']}' | Email: '{$user['email']}' | Name: {$user['name']}<br>";
    }
    
    // Test authentication with exact data
    echo "<h2>Authentication Test:</h2>";
    echo "Testing username 'admin' with password 'admin123'<br>";
    
    $result = $userModel->authenticate('admin', 'admin123');
    if ($result) {
        echo "<strong>SUCCESS!</strong><br>";
        print_r($result);
    } else {
        echo "<strong>FAILED!</strong><br>";
        
        // Check the password hash directly
        echo "<h3>Password Hash Check:</h3>";
        $query = "SELECT username, password_hash FROM users WHERE username = 'admin'";
        // We need to check the actual hash
    }
    
    // Test password verification manually
    echo "<h2>Manual Password Test:</h2>";
    $testHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    if (password_verify('admin123', $testHash)) {
        echo "Password verification function works correctly<br>";
    } else {
        echo "Password verification function failed<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
