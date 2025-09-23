<?php
// single front controller: bootstraps app, wires autoload, hands off to router
final class Index {
  public static function run() { self::init(); self::handle(); }

  private static function init() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    error_reporting(E_ERROR | E_STRICT);

    // base URL for asset + link generation (no trailing file)
    define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));
    define('TITLE', 'EventManager · MVC');

    // autoload classes from these folders in order
    spl_autoload_register(['Index', 'loadClass']);
  }

  private static function loadClass($class) {
    $dirs = ['app/','app/router/','app/model/','app/view/','app/controller/','app/filter/','app/db/'];
    foreach ($dirs as $d) {
      $f = $d . $class . '.php';
      if (file_exists($f)) { require_once $f; return true; }
    }
    return false;
  }

  private static function handle() {
    // hand query string to the regex router (e.g., ?event/show&id=1)
    $router = new Router();
    $router->dispatch($_SERVER["QUERY_STRING"] ?? '');
  }
}
Index::run();
