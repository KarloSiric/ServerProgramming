<?php
/**
 * Index.php - Application Bootstrap
 * 
 * This is the main entry point for the Event Horizon application.
 * All requests are routed through this file via .htaccess rewrite rules.
 * 
 * Responsibilities:
 * - Initialize application constants
 * - Set up autoloading for classes
 * - Dispatch requests to the appropriate controller via Router
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Final class Index
 * 
 * Main application bootstrap class that initializes the application
 * and handles incoming HTTP requests.
 */
final class Index {

    /**
     * Run the application
     * 
     * Main entry point that initializes the application and handles the request.
     * 
     * @return void
     */
    public static function run() {
        self::init();
        self::handle();
    }

    /**
     * Initialize application
     * 
     * Sets up error reporting, defines application constants, and registers
     * the autoloader for dynamic class loading.
     * 
     * @return void
     */
    private static function init() {
        error_reporting(E_ERROR | E_STRICT);

        // Define application constants
        define('CONFIG_PATH', __DIR__ . '/config');
        define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));
        define('TITLE', 'Event Horizon');
        
        // Register autoloader
        spl_autoload_register(['Index', 'loadClass']);
    }

    /**
     * Autoload class files
     * 
     * Automatically loads class files from predefined directories when a class
     * is instantiated. Searches through common application directories.
     * 
     * @param string $class_name The name of the class to load
     * @return bool True if class file was found and loaded, false otherwise
     */
    private static function loadClass($class_name) {
        $dirs = array(
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/service/',
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

    /**
     * Handle incoming request
     * 
     * Extracts the URL from the request, cleans it, and dispatches it
     * to the Router for processing.
     * 
     * @return void
     */
    private static function handle() {
        $router = new Router();
        
        // Get URL from the 'url' parameter set by .htaccess
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        
        $router->dispatch($url);
    }
}

// Start the application
Index::run();
