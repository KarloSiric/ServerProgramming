<?php
/**
 * Router.php - URL Routing System
 * 
 * Handles URL parsing and routing requests to appropriate controllers
 * and actions. Uses pattern matching to extract controller, action,
 * and parameters from clean URLs.
 * 
 * URL Format: /controller/action/param1/param2/...
 * Example: /event/edit/5 -> EventController->edit([5])
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Final class Router
 * 
 * Parses incoming URLs and dispatches requests to the appropriate
 * controller and method with extracted parameters.
 */
final class Router {

    /**
     * @var string $pattern Regex pattern for parsing URLs
     */
    private $pattern = "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\w-]*)\/?$/";
    
    /**
     * @var string $controller Default controller class name
     */
    private $controller = 'UserController';
    
    /**
     * @var string $action Default action method name
     */
    private $action = 'login';
    
    /**
     * @var array $params Default parameters array
     */
    private $params = [];

    /**
     * Dispatch request to controller
     * 
     * Parses the query string, determines the controller and action,
     * instantiates the controller, and calls the action method with parameters.
     * 
     * @param string $query_string The URL path to route
     * @return void
     * @throws Exception If controller class or method is not found
     */
    public function dispatch($query_string) {
        $query_string = trim($query_string, '/');
        
        // Parse URL if not empty
        if ($query_string && ($parsed = $this->parse($query_string))) {
            $this->controller = $parsed['controller'];
            $this->action = $parsed['action'];
            $this->params = $parsed['params'];
        }

        // Instantiate controller and call action
        if (class_exists($this->controller)) {
            $controller = new $this->controller();
            if (is_callable([$controller, $this->action])) {
                $controller->{$this->action}($this->params);
            } else {
                throw new Exception("Method '$this->action' in controller '$this->controller' not found");
            }
        } else {
            throw new Exception("Controller class '$this->controller' not found");
        }
    }

    /**
     * Parse URL into components
     * 
     * Uses regex to extract controller, action, and parameters from URL.
     * Filters out empty parameter values and converts controller name to
     * proper class name format (e.g., 'user' -> 'UserController').
     * 
     * @param string $query_string The URL path to parse
     * @return array|false Associative array with controller, action, and params, or false if no match
     */
    private function parse($query_string) {
        if (preg_match($this->pattern, $query_string, $matches)) {
            // Convert controller name to class name format
            $controller = ucfirst($matches["controller"]) . 'Controller';
            $action = $matches["action"];
            
            // Split params and filter out empty values
            $params = array_values(array_filter(
                explode("/", ltrim($matches["params"], "/")),
                fn($p) => $p !== ''
            ));
            
            return [
                'controller' => $controller,
                'action' => $action,
                'params' => $params
            ];
        }
        return false;
    }
}
