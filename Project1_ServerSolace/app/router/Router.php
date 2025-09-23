<?php
// Clean regex router based on your friend's approach
final class Router {
    private string $pattern = "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/.\w-]*)*\/?$/i";
    private string $controller = "UserController";  // Default to user dashboard like your app
    private string $action = "dashboard";           // Logical default for your event system
    private array $params = [];

    public function dispatch(?string $query) {
        // Extract just the routing part, ignore query parameters (&id=1, etc.)
        $routePart = $query ? explode('&', $query, 2)[0] : '';

        // Parse the route if provided
        if ($routePart && ($parsed = $this->parse($routePart))) {
            $this->controller = $parsed['controller'];
            $this->action = $parsed['action'];
            $this->params = $parsed['params'] ?? [];
        }

        // Verify controller exists
        if (!class_exists($this->controller)) {
            throw new Exception("Controller {$this->controller} not found");
        }

        // Create controller instance
        $controllerInstance = new $this->controller();

        // Verify action method exists
        if (!is_callable([$controllerInstance, $this->action])) {
            throw new Exception("Action {$this->action} not found on {$this->controller}");
        }

        // Smart parameter passing - only pass params if method accepts them
        $reflection = new ReflectionMethod($controllerInstance, $this->action);
        if (!empty($this->params) && $reflection->getNumberOfParameters() > 0) {
            $controllerInstance->{$this->action}($this->params);
        } else {
            $controllerInstance->{$this->action}();
        }
    }

    private function parse(string $route) {
        if (preg_match($this->pattern, $route, $matches)) {
            return [
                'controller' => ucfirst($matches['controller']) . 'Controller',
                'action' => $matches['action'],
                'params' => array_filter(explode("/", ltrim($matches['params'], "/")))
            ];
        }
        return false;
    }
}
