<?php
// Test file to check if everything is working

// Start session
session_start();

echo "<h1>MVC System Test</h1>";

// Test autoloading
echo "<h2>1. Testing Autoloader:</h2>";

// Define autoloader
spl_autoload_register(function($class_name) {
    $dirs = array(
        'app/',
        'app/controller/',
        'app/model/',
        'app/view/',
        'app/core/'
    );
    
    foreach ($dirs as $dir) {
        $file = $dir . $class_name . '.php';
        if (file_exists($file)) {
            require_once($file);
            echo "✓ Loaded: $file<br>";
            return true;
        }
    }
    echo "✗ Could not find: $class_name<br>";
    return false;
});

// Test loading classes
echo "<h3>Loading Controllers:</h3>";
if (class_exists('Controller')) {
    echo "✓ Base Controller loaded<br>";
} else {
    echo "✗ Base Controller NOT found<br>";
}

if (class_exists('UserController')) {
    echo "✓ UserController loaded<br>";
} else {
    echo "✗ UserController NOT found<br>";
}

echo "<h3>Loading Models:</h3>";
if (class_exists('Model')) {
    echo "✓ Base Model loaded<br>";
} else {
    echo "✗ Base Model NOT found<br>";
}

if (class_exists('UserModel')) {
    echo "✓ UserModel loaded<br>";
} else {
    echo "✗ UserModel NOT found<br>";
}

echo "<h2>2. Testing Login Form:</h2>";
?>

<form method="POST" action="test.php">
    <input type="text" name="username" placeholder="Username" value="organizer">
    <input type="password" name="password" placeholder="Password" value="org123">
    <button type="submit">Test Login</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>3. Testing Authentication:</h2>";
    
    $userModel = new UserModel();
    $result = $userModel->authenticate();
    
    if ($result) {
        echo "✓ Login successful!<br>";
        echo "Username: " . $result['username'] . "<br>";
        echo "Email: " . $result['email'] . "<br>";
        echo "Role: " . $result['role'] . "<br>";
    } else {
        echo "✗ Login failed<br>";
    }
}
?>

<hr>
<h2>Links to test:</h2>
<ul>
    <li><a href="Index.php">Index.php (should show login)</a></li>
    <li><a href="user/login">user/login (clean URL)</a></li>
    <li><a href="user/register">user/register (clean URL)</a></li>
</ul>
