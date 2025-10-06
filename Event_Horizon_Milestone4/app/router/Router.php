<?php
final class Router
{
    private string $pattern = '/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\w-]*)\/?$/';

    private string $controller = 'UserController';
    private string $action     = 'login';
    private array  $params     = [];

    public function dispatch(string $queryString): void
    {
        $queryString = trim($queryString, '/');

        // Pretty URLs: /user/login/123
        if ($queryString && ($parsed = $this->parse($queryString))) {
            $this->controller = $parsed['controller'];
            $this->action     = $parsed['action'];
            $this->params     = $parsed['params'];
        } else {
            // Legacy GET: ?controller=user&action=login
            $c = $_GET['controller'] ?? null;
            $a = $_GET['action'] ?? null;
            if ($c) { $this->controller = ucfirst(strtolower((string)$c)) . 'Controller'; }
            if ($a) { $this->action = (string)$a; }
        }

        if (!class_exists($this->controller)) {
            throw new Exception("Controller class '{$this->controller}' not found");
        }

        $controller = new $this->controller();

        if (!is_callable([$controller, $this->action])) {
            throw new Exception("Method '{$this->action}' not found on {$this->controller}");
        }

        // IMPORTANT: Only pass params if there are any.
        $params = array_values(array_filter($this->params, static function($p) {
            return $p !== '' && $p !== null;
        }));

        if (empty($params)) {
            $controller->{$this->action}();              // e.g., login()
        } else {
            call_user_func_array([$controller, $this->action], $params); // e.g., show($id)
        }
    }

    private function parse(string $queryString)
    {
        if (preg_match($this->pattern, $queryString, $m)) {
            $controller = ucfirst($m['controller']) . 'Controller';
            $action     = $m['action'];
            $params     = explode('/', ltrim($m['params'], '/'));
            return compact('controller', 'action', 'params');
        }
        return false;
    }
}
