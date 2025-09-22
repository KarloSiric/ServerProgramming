<?php
// Router script for PHP built-in server
// This makes clean URLs work with php -S localhost:9000

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If requesting a real file (like CSS, JS, images), serve it
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Otherwise, route everything through Index.php
$_SERVER['QUERY_STRING'] = trim($uri, '/');
require_once __DIR__ . '/Index.php';
