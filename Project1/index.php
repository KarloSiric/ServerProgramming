<?php
// index.php - Front Controller for Event Management System

declare(strict_types=1);
session_start();

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . "/app/controller/$class.php",
        __DIR__ . "/app/model/$class.php", 
        __DIR__ . "/app/router/$class.php",
        __DIR__ . "/$class.php", // For root level classes
    ];
    foreach ($paths as $path) {
        if (is_file($path)) { 
            require_once $path; 
            return; 
        }
    }
});

// Boot the router and dispatch
$router = new Router();
[$controllerName, $action] = $router->resolve();

// Instantiate controller and call action
if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "Controller '$controllerName' not found.";
    exit;
}

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo "Action '$action' not found on '$controllerName'.";
    exit;
}

$controller->$action();
