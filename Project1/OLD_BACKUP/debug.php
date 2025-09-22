<?php
session_start();

echo "<h1>Debug: What's Actually Happening</h1>";

echo "<h2>Server Variables:</h2>";
echo "<pre>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'EMPTY') . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "</pre>";

echo "<h2>Test Links:</h2>";
echo '<a href="/user/welcome">Click this link and see what happens</a><br>';
echo '<a href="/Index.php">Index.php</a><br>';

echo "<h2>Test Login Form:</h2>";
?>
<form method="POST" action="/user/welcome">
    <input type="text" name="username" value="organizer" placeholder="Username">
    <input type="password" name="password" value="org123" placeholder="Password">
    <button type="submit">Test Submit</button>
</form>

<?php
if ($_POST) {
    echo "<h2>POST Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

// Test if classes can be loaded
echo "<h2>Can we load classes?</h2>";

// Manual include to test
if (file_exists('app/controller/Controller.php')) {
    echo "✓ Controller.php exists<br>";
    require_once 'app/controller/Controller.php';
    
    if (file_exists('app/controller/UserController.php')) {
        echo "✓ UserController.php exists<br>";
        require_once 'app/controller/UserController.php';
        
        if (file_exists('app/model/Model.php')) {
            echo "✓ Model.php exists<br>";
            require_once 'app/model/Model.php';
            
            if (file_exists('app/model/UserModel.php')) {
                echo "✓ UserModel.php exists<br>";
                require_once 'app/model/UserModel.php';
                
                // Try to authenticate
                echo "<h2>Testing Authentication Directly:</h2>";
                if ($_POST) {
                    $model = new UserModel();
                    $result = $model->getViewModel();
                    echo "<pre>";
                    echo "Result from getViewModel(): ";
                    var_dump($result);
                    echo "</pre>";
                }
            }
        }
    }
} else {
    echo "✗ Cannot find Controller.php - ARE YOU IN THE RIGHT DIRECTORY?<br>";
    echo "Current directory: " . getcwd() . "<br>";
}
?>
