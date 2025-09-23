<?php
// DIAGNOSTIC MODE - This will help us see exactly what's happening

// Force display of all errors - even ones that would normally be hidden
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html><html><head><title>EventHorizon Diagnostic</title>";
echo "<style>body{font-family:Arial;margin:20px;} .step{background:#e8f5e8;padding:10px;margin:5px 0;border-left:4px solid #4CAF50;} .error{background:#ffe8e8;padding:10px;margin:5px 0;border-left:4px solid #f44336;}</style>";
echo "</head><body><h1>EventHorizon System Diagnostic</h1>";

// Checkpoint 1: Basic PHP execution
echo "<div class='step'>✅ Step 1: PHP is executing - we can see this message</div>";

// Checkpoint 2: Session functionality
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    echo "<div class='step'>✅ Step 2: Session system is working</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Step 2 FAILED: Session error - " . $e->getMessage() . "</div>";
}

// Checkpoint 3: File system access
if (file_exists('app/')) {
    echo "<div class='step'>✅ Step 3: Can access app/ directory</div>";
} else {
    echo "<div class='error'>❌ Step 3 FAILED: Cannot find app/ directory</div>";
}

// Checkpoint 4: Router file exists
if (file_exists('app/router/Router.php')) {
    echo "<div class='step'>✅ Step 4: Router.php file exists</div>";
    
    // Try to include it
    try {
        require_once 'app/router/Router.php';
        echo "<div class='step'>✅ Step 4b: Router.php loaded successfully</div>";
        
        if (class_exists('Router')) {
            echo "<div class='step'>✅ Step 4c: Router class is available</div>";
        } else {
            echo "<div class='error'>❌ Step 4c FAILED: Router class not found after loading file</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>❌ Step 4b FAILED: Error loading Router.php - " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='error'>❌ Step 4 FAILED: Router.php file missing</div>";
}

// Checkpoint 5: Controller files
$controllerFiles = ['UserController.php', 'AdminController.php', 'EventController.php'];
foreach ($controllerFiles as $file) {
    if (file_exists('app/controller/' . $file)) {
        echo "<div class='step'>✅ Step 5: Found $file</div>";
    } else {
        echo "<div class='error'>❌ Step 5 FAILED: Missing $file</div>";
    }
}

// Checkpoint 6: Try creating a simple router instance
try {
    if (class_exists('Router')) {
        $router = new Router();
        echo "<div class='step'>✅ Step 6: Router instance created successfully</div>";
    } else {
        echo "<div class='error'>❌ Step 6 FAILED: Cannot create Router - class not available</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Step 6 FAILED: Router creation error - " . $e->getMessage() . "</div>";
}

// Show server information that might be helpful
echo "<h2>Server Information</h2>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "</p>";
echo "<p><strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'not set') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";

// Show what files are actually in key directories
echo "<h2>File System Check</h2>";
if (is_dir('app/controller/')) {
    echo "<p><strong>Controllers found:</strong></p><ul>";
    foreach (scandir('app/controller/') as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
}

if (is_dir('app/view/user/')) {
    echo "<p><strong>User views found:</strong></p><ul>";
    foreach (scandir('app/view/user/') as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
}

echo "<h2>Next Steps</h2>";
echo "<p>If you see this diagnostic page, the basic PHP execution is working. Any errors above will tell us exactly where the problem lies.</p>";
echo "<p><a href='?user/login'>Test Login Link</a> | <a href='?admin/overview'>Test Admin Link</a></p>";

echo "</body></html>";
?>
