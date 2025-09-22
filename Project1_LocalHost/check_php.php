<?php
echo "<h1>PHP Configuration Check</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Password hashing available: " . (function_exists('password_hash') ? 'YES' : 'NO') . "<br>";
echo "Password verify available: " . (function_exists('password_verify') ? 'YES' : 'NO') . "<br>";

// Check what hashing algorithms are available
echo "<h2>Available algorithms:</h2>";
print_r(password_algos());

// Test basic hashing
echo "<h2>Basic Hash Test:</h2>";
$test_password = 'test123';
$hash = password_hash($test_password, PASSWORD_DEFAULT);
echo "Generated hash: $hash<br>";
echo "Verification result: " . (password_verify($test_password, $hash) ? 'SUCCESS' : 'FAILED') . "<br>";

// Check loaded extensions
echo "<h2>Relevant Extensions:</h2>";
$extensions = ['hash', 'openssl', 'sodium'];
foreach ($extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? 'LOADED' : 'NOT LOADED') . "<br>";
}
?>
