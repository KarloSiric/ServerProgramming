<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Info</h1>";
echo "<pre>";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "\n";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'not set') . "\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "\nPATHINFO_DIRNAME: " . pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_DIRNAME) . "\n";
echo "\nGenerated PROJECT_URL would be:\n";
echo 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
echo "\n\n_GET variables:\n";
print_r($_GET);
echo "</pre>";

// Test file access
echo "<h2>File Check</h2>";
echo "Index.php exists: " . (file_exists('Index.php') ? 'YES' : 'NO') . "<br>";
echo ".htaccess exists: " . (file_exists('.htaccess') ? 'YES' : 'NO') . "<br>";
echo "Current directory: " . getcwd() . "<br>";
