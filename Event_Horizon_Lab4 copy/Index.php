<?php
final class Index
{
    public static function run(): void
    {
        self::init();
        self::handle();
    }

    private static function init(): void
    {
        error_reporting(E_ERROR | E_STRICT);

        define('CONFIG_PATH', __DIR__ . '/config');
        define('APP_PATH', __DIR__ . '/app');

        $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        define('PROJECT_URL', $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $basePath);

        define('PROJECT_TITLE', 'Event Horizon');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['LAST_ACTIVITY'] = $_SESSION['LAST_ACTIVITY'] ?? time();

        $ini = @parse_ini_file(CONFIG_PATH . '/config.ini', true) ?: [];
        $timeout = (int)($ini['session']['session_timeout'] ?? 300);
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - (int)$_SESSION['LAST_ACTIVITY']) > $timeout) {
            session_unset();
            session_destroy();
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }
        $_SESSION['LAST_ACTIVITY'] = time();

        spl_autoload_register([self::class, 'loadClass']);
    }

    private static function loadClass(string $class): bool
    {
        $dirs = [
            'app/', 'app/router/', 'app/model/', 'app/controller/', 'app/filter/', 'config/'
        ];
        foreach ($dirs as $dir) {
            $f = __DIR__ . '/' . $dir . $class . '.php';
            if (is_file($f)) { require_once $f; return true; }
        }
        return false;
    }

    private static function handle(): void
    {
        $router = new Router();
        $router->dispatch($_SERVER['QUERY_STRING'] ?? ''); // supports both regex and GET fallback
    }
}
