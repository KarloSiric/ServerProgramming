<?php
declare(strict_types=1);
session_start();

final class Index
{
    public static function init(): void
    {
        // Errors (dev mode)
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        // Paths
        define('ROOT_PATH', __DIR__);
        define('APP_PATH', ROOT_PATH . '/app');
        define('CORE_PATH', ROOT_PATH . '/core');
        define('VIEW_PATH', APP_PATH . '/view');
        define('PUBLIC_PATH', ROOT_PATH . '/public');
        define('CONFIG_PATH', ROOT_PATH . '/config');

        // Title
        define('PROJECT_TITLE', 'Event Horizon');

        // BASE_PATH works both on XAMPP and Solace (no trailing slash)
        $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        define('BASE_PATH', $scriptDir === '' ? '' : $scriptDir);

        // Autoload (controllers, models, core)
        spl_autoload_register(function (string $class): void {
            $candidates = [
                APP_PATH . '/controller/' . $class . '.php',
                APP_PATH . '/model/' . $class . '.php',
                CORE_PATH . '/' . $class . '.php',
            ];
            foreach ($candidates as $file) {
                if (is_readable($file)) {
                    require_once $file;
                    return;
                }
            }
        });

        self::handle();
    }

    private static function handle(): void
    {
        $controllerParam = $_GET['controller'] ?? 'user';
        $action = $_GET['action'] ?? 'login';

        $controllerClass = ucfirst(strtolower((string)$controllerParam)) . 'Controller';

        if (!class_exists($controllerClass)) {
            self::renderError("Controller '{$controllerClass}' not found.");
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            self::renderError("Action '{$action}' not found on {$controllerClass}.");
            return;
        }

        $controller->$action();
    }

    private static function renderError(string $message): void
    {
        include VIEW_PATH . '/inc/header.php';
        echo "<div class='alert-error' style='margin:1rem 0'>{$message}</div>";
        include VIEW_PATH . '/inc/footer.php';
    }
}

Index::init();
