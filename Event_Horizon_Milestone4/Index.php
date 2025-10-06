<?php
declare(strict_types=1);

/**
 * Bootstrap (Dario-style mechanics, your branding)
 * NOTE: Keep this file name lowercase: index.php (Linux is case-sensitive)
 */

// TEMP for debugging white screen — remove after it works
ini_set('display_errors', '1');
error_reporting(E_ALL);

final class Index
{
    public static function run(): void
    {
        self::init();
        self::handle();
    }

    private static function init(): void
    {
        // Paths
        define('CONFIG_PATH', __DIR__ . '/config');
        define('APP_PATH', __DIR__ . '/app');

        // URL + BASE_PATH (used by your views)
        $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        define('PROJECT_URL', $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $basePath);
        define('BASE_PATH', $basePath === '' ? '' : $basePath);

        // Title (your project)
        define('PROJECT_TITLE', 'Event Horizon');

        // Session + inactivity timeout (configurable)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ini = @parse_ini_file(CONFIG_PATH . '/config.ini', true) ?: [];
        $timeout = (int)($ini['session']['session_timeout'] ?? 300);
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - (int)$_SESSION['LAST_ACTIVITY']) > $timeout) {
            session_unset();
            session_destroy();
            header('Location: ' . PROJECT_URL . '/index.php?controller=user&action=login');
            exit;
        }
        $_SESSION['LAST_ACTIVITY'] = time();

        // Autoload
        spl_autoload_register([self::class, 'loadClass']);
    }

    private static function loadClass(string $class): bool
    {
        $dirs = [
            'app/', 'app/router/', 'app/model/', 'app/controller/', 'app/filter/', 'config/'
        ];
        foreach ($dirs as $dir) {
            $file = __DIR__ . '/' . $dir . $class . '.php';
            if (is_file($file)) {
                require_once $file;
                return true;
            }
        }
        return false;
    }

    private static function handle(): void
    {
        try {
            $router = new Router();
            $router->dispatch($_SERVER['QUERY_STRING'] ?? '');
        } catch (Throwable $e) {
            http_response_code(500);
            // Minimal inline error so you see what broke instead of a blank page
            echo "<pre style='padding:1rem;border:1px solid #ccc;border-radius:8px;background:#fff'>
" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }
}

Index::run();
