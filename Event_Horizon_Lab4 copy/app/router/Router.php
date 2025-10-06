<?php
final class Router
{
    private string $pattern = '/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\w-]*)\/?$/';

    private string $controller = 'UserController';  // default
    private string $action     = 'login';           // default (username login)
    private array  $params     = [];

    public function dispatch(string $queryString): void
    {
        $queryString = trim($queryString, '/'); // normalize

        // 1) Pretty URLs: Index.php/user/login/123
        if ($queryString && ($parsed = $this->parse($queryString))) {
            $this->controller = $parsed['controller'];
            $this->action     = $parsed['action'];
            $this->params     = $parsed['params'];
        } else {
            // 2) Legacy GET (YOUR headers/links): Index.php?controller=user&action=login
            $c = $_GET['controller'] ?? null; 
            $a = $_GET['action'] ?? null;
            if ($c) { $this->controller = ucfirst(strtolower((string)$c)) . 'Controller'; }
            if ($a) { $this->action = (string)$a; }
        }

        if (class_exists($this->controller)) {
            $controller = new $this->controller();
            if (is_callable([$controller, $this->action])) {
                $controller->{$this->action}($this->params);
                return;
            }
            throw new Exception("Method '{$this->action}' in controller '{$this->controller}' not found");
        }
        throw new Exception("Controller class '{$this->controller}' not found");
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
