<?php
// Router.php - Final fix for server deployment
class Router
{
    public function resolve(): array
    {
        // Get the path from REQUEST_URI
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH);
        
        // Remove the base path (/~ks9700/iste-341/Project1/)
        $basePath = '/~ks9700/iste-341/Project1';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Remove leading/trailing slashes
        $path = trim($path, '/');
        
        // Default route (empty path or index.php)
        if ($path === '' || $path === 'index.php') {
            return ['UserController', 'login'];
        }
        
        // Split path into segments
        $segments = explode('/', $path);
        $controller = $segments[0] ?? 'user';
        $action = $segments[1] ?? 'login';
        
        // Route mapping
        switch ($controller) {
            case 'user':
                return ['UserController', $action];
                
            case 'admin':
                return ['AdminController', $action];
                
            case 'event':
                return ['EventController', $action];
                
            default:
                // If we can't match, default to user login
                return ['UserController', 'login'];
        }
    }
}
