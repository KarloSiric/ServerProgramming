<?php
echo "<h1>Debug Info</h1>";
echo "<pre>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "QUERY_STRING: " . $_SERVER['QUERY_STRING'] . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'not set') . "\n";
echo "\n\$_SERVER dump:\n";
print_r($_SERVER);
echo "</pre>";
