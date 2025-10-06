<?php

/**
 * Final class Index
 */


final class Index {

    public static function run() {
        self::init();
        self::handle();
    }

    private static function init() {
        error_reporting(E_ERROR | E_STRICT);

        // Define constants
        define('CONFIG_PATH', __DIR__ . '/config');
        define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));
        define('TITLE', 'Event Horizon');
        
        // Autoloader
        spl_autoload_register(['Index', 'loadClass']);
    }

    private static function loadClass($class_name) {
        $dirs = array(
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/service/',  // ADDED THIS
            'app/filter/',
            'config/'
        );

        foreach ($dirs as $dir) {
            if (file_exists($dir . $class_name . '.php')) {
                require_once($dir . $class_name . '.php');
                return true;
            }
        }
        return false;
    }

    private static function handle() {
        $router = new Router();
        
        // Get URL from the 'url' parameter set by .htaccess
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        
        $router->dispatch($url);
    }
}

Index::run();
