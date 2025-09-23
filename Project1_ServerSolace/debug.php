<!DOCTYPE html>
<html>
<head>
    <title>URL Debug</title>
    <style>body { font-family: Arial; margin: 40px; }</style>
</head>
<body>
    <h2>URL Debug Info</h2>
    <p><strong>Current URL:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'undefined' ?></p>
    <p><strong>Script Name:</strong> <?= $_SERVER['SCRIPT_NAME'] ?? 'undefined' ?></p>
    <p><strong>Path Info:</strong> <?= $_SERVER['PATH_INFO'] ?? 'none' ?></p>
    
    <h3>Test Links:</h3>
    <ul>
        <li><a href="/~ks9700/iste-341/Project1/">Home</a></li>
        <li><a href="/~ks9700/iste-341/Project1/user/dashboard">Dashboard</a></li>
        <li><a href="/~ks9700/iste-341/Project1/user/logout">Logout</a></li>
    </ul>
    
    <h3>Router Test:</h3>
    <?php
    require_once __DIR__ . '/app/router/Router.php';
    $router = new Router();
    [$controller, $action] = $router->resolve();
    echo "<p>Controller: $controller</p>";
    echo "<p>Action: $action</p>";
    ?>
</body>
</html>
