<?php
echo "<h1>Password Function Repair Test</h1>";

// Test 1: Basic functionality
$password = 'admin123';
$hash1 = password_hash($password, PASSWORD_BCRYPT);
$hash2 = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Generated Hashes:</h2>";
echo "BCRYPT: $hash1<br>";
echo "DEFAULT: $hash2<br>";

echo "<h2>Verification Tests:</h2>";
echo "BCRYPT verify: " . (password_verify($password, $hash1) ? 'SUCCESS' : 'FAILED') . "<br>";
echo "DEFAULT verify: " . (password_verify($password, $hash2) ? 'SUCCESS' : 'FAILED') . "<br>";

// Test 2: Try with explicit algorithm
if (defined('PASSWORD_BCRYPT')) {
    $hash3 = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    echo "Explicit BCRYPT: " . (password_verify($password, $hash3) ? 'SUCCESS' : 'FAILED') . "<br>";
    echo "Use this hash for admin: $hash3<br>";
}

// Test 3: Check PHP version and extensions
echo "<h2>System Info:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Sodium available: " . (extension_loaded('sodium') ? 'YES' : 'NO') . "<br>";
echo "Hash available: " . (extension_loaded('hash') ? 'YES' : 'NO') . "<br>";
?>
