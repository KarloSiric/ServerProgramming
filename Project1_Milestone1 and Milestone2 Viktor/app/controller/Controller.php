<?php
// base controller: knows how to resolve a model and render a view
class Controller {
  public function model() {
    // FooController -> FooModel; if missing, use AppModel (demo data)
    $model = str_replace("Controller","Model", get_class($this));
    if (!class_exists($model)) $model = 'AppModel'; // fallback single model
    return new $model();
  }

  public function view($data = []) {
    // resolve "controller/action" to app/view/{controller}/{action}.php
    $controller = strtolower(str_replace('Controller', '', get_called_class()));
    $action     = debug_backtrace()[1]['function'];
    $tpl = "app/view/{$controller}/{$action}.php";
    if (!file_exists($tpl)) throw new Exception("Missing view: $tpl");

    // shared layout + content
    require 'app/view/inc/header.php';
    require $tpl;
    require 'app/view/inc/footer.php';
  }

  protected function requireRole(string $role) {
    // simple role check; shows a 403 and stops
    $r = $_SESSION['user']['role'] ?? 'guest';
    if ($r !== $role) {
      http_response_code(403);
      require 'app/view/inc/header.php';
      echo "<div class='alert alert-danger mt-3'>403 – {$role} required</div>";
      require 'app/view/inc/footer.php';
      exit;
    }
  }
}
