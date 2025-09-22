<?php
echo "<h1>Create Working Password Hash</h1>";

// Generate a fresh hash for 'admin123'
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<p>Generated hash for 'admin123': <br>";
echo "<code>$hash</code></p>";

// Test it immediately
if (password_verify($password, $hash)) {
    echo "<p>✅ This hash WORKS for 'admin123'</p>";
    
    echo "<h2>Copy this SQL to phpMyAdmin:</h2>";
    echo "<textarea style='width:100%;height:100px;'>";
    echo "UPDATE users SET password_hash = '$hash' WHERE username = 'admin';";
    echo "</textarea>";
    
} else {
    echo "<p>❌ Hash generation failed - PHP password functions broken</p>";
}
?>
