<?php
// tiny regex router; parses "?controller/action" and ignores the rest (&id=1, etc.)
final class Router {
  private string $pattern    = "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\d+]*)\/?$/";
  private string $controller = "SiteController";
  private string $action     = "home";
  private array  $params     = [];

  public function dispatch(?string $query) {
    // keep only "controller/action"; everything after & stays available in $_GET
    $routePart = $query ? explode('&', $query, 2)[0] : '';

    if ($routePart && ($p = $this->parse($routePart))) {
      $this->controller = $p['controller'];
      $this->action     = $p['action'];
      $this->params     = $p['params'] ?? [];
    }

    if (!class_exists($this->controller)) {
      throw new Exception("Controller {$this->controller} not found");
    }

    $c = new $this->controller();

    if (!is_callable([$c, $this->action])) {
      throw new Exception("Action {$this->action} not found on {$this->controller}");
    }

    // pass params only if the action actually accepts them
    $ref = new ReflectionMethod($c, $this->action);
    if (!empty($this->params) && $ref->getNumberOfParameters() > 0) {
      $c->{$this->action}($this->params);
    } else {
      $c->{$this->action}();
    }
  }

  private function parse(string $q) {
    if (preg_match($this->pattern, $q, $m)) {
      return [
        'controller' => ucfirst($m['controller']) . 'Controller',
        'action'     => $m['action'],
        'params'     => explode("/", ltrim($m['params'], "/")),
      ];
    }
    return false;
  }
}
