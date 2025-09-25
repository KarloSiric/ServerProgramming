<?php
/**
 * @file Index.php
 * @brief Single entry point for the entire EventHorizon application
 * 
 * This is the front controller pattern implementation. ALL requests to the application
 * go through this single file. It bootstraps the application, sets up autoloading,
 * initializes constants, and dispatches requests to the appropriate controllers.
 * 
 * @details Request Flow:
 * 1. User visits any URL (e.g., /Index.php?event/show&id=1)
 * 2. Apache .htaccess redirects all requests to this file
 * 3. This file initializes the application via Index::run()
 * 4. The Router parses the query string and calls the appropriate Controller/Action
 * 5. The Controller processes the request and renders a View
 * 6. The response is sent back to the user
 * 
 * @author KarloSiric
 * @version 1.0
 * @date 2025
 * 
 * @see Router For URL routing logic
 * @see Controller For base controller functionality
 * 
 * @note This file MUST be in the root directory
 * @note All URLs go through this file via .htaccess
 */

/**
 * @class Index
 * @brief Main application bootstrap class
 * 
 * This class is responsible for initializing the entire application.
 * It sets up the environment, configures autoloading, and handles the request.
 * Uses a static run() method as the single entry point.
 * 
 * @note This is a final class - cannot be extended
 */
final class Index {
  /**
   * @brief Main entry point - starts the entire application
   * 
   * Called at the bottom of this file. Initializes environment and handles request.
   * This is the ONLY method called directly in the entire application bootstrap.
   * 
   * @return void
   * @throws Exception If critical initialization fails
   * 
   * @note Called directly at bottom of this file
   */
  public static function run() { 
    self::init();    // Initialize environment, session, constants
    self::handle();  // Pass control to the Router
  }

  /**
   * @brief Initialize application environment
   * 
   * Sets up:
   * - PHP session (if not already started)
   * - Error reporting level
   * - PROJECT_URL constant for generating links
   * - TITLE constant for page titles
   * - Autoloader for classes
   * 
   * @return void
   * @internal This method is private and only called by run()
   * 
   * @note SESSION MUST be started before any output
   */
  private static function init() {
    // Start session if not already started - required for user authentication
    // This MUST happen before ANY output is sent to browser
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // Set error reporting - show only errors and strict warnings (not notices)
    // In production, you might want to set this to 0 and log errors instead
    error_reporting(E_ERROR | E_STRICT);

    /**
     * Define PROJECT_URL constant
     * Used throughout views to generate absolute URLs
     * Example: https://solace.ist.rit.edu/~ks9700/iste-341/Project1
     * 
     * Components:
     * - $_SERVER['HTTP_HOST'] = solace.ist.rit.edu
     * - $_SERVER['SCRIPT_NAME'] = /~ks9700/iste-341/Project1/Index.php
     * - pathinfo(..., PATHINFO_DIRNAME) removes Index.php
     */
    define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));
    
    /**
     * Define default title for pages
     * Can be overridden in individual views by setting $title
     */
    define('TITLE', 'EventHorizon · MVC');

    /**
     * Register autoloader
     * When a class is used but not yet loaded, loadClass() will be called
     * This eliminates the need for manual require/include statements
     * 
     * Example: When "new EventController()" is called:
     * 1. PHP checks if EventController is loaded
     * 2. If not, calls Index::loadClass('EventController')
     * 3. loadClass searches directories and loads the file
     */
    spl_autoload_register(['Index', 'loadClass']);
  }

  /**
   * @brief Autoloader for PHP classes
   * 
   * Called automatically when a class is used but not yet loaded.
   * Searches through predefined directories for the class file.
   * 
   * @param string $class Name of the class to load (e.g., 'EventController')
   * @return bool True if class was loaded, false otherwise
   * 
   * @details Search order (first match wins):
   * 1. app/ (for any top-level app classes)
   * 2. app/router/ (for Router class)
   * 3. app/model/ (for Model classes like AppModel, Model)
   * 4. app/view/ (for any View helpers - though views are mostly includes)
   * 5. app/controller/ (for Controller classes like EventController)
   * 6. app/filter/ (for future Filter/Middleware classes)
   * 7. app/db/ (for future Database classes)
   * 
   * @note File naming convention: ClassName.php
   * @example EventController class must be in EventController.php
   */
  private static function loadClass($class) {
    // Directories to search for classes, in order of likelihood
    $dirs = [
      'app/',              // Base app directory
      'app/router/',       // Router class (Router.php)
      'app/model/',        // Model classes (AppModel.php, Model.php)
      'app/view/',         // View helpers (if any)
      'app/controller/',   // All controllers (EventController.php, etc.)
      'app/filter/',       // Future: middleware/filters
      'app/db/'           // Future: database connection classes
    ];
    
    // Try each directory until we find the class
    foreach ($dirs as $d) {
      $f = $d . $class . '.php';  // Build file path
      if (file_exists($f)) { 
        require_once $f;  // Load the file once
        return true;      // Success - stop searching
      }
    }
    return false;  // Class file not found
  }

  /**
   * @brief Handle the incoming request
   * 
   * Creates a Router instance and delegates request handling to it.
   * The Router will parse the URL and call the appropriate Controller/Action.
   * 
   * @return void
   * @throws Exception If Router class not found or routing fails
   * 
   * @see Router::dispatch() For actual routing logic
   * 
   * @note Query string examples:
   * - "" or null → SiteController::home()
   * - "event/show&id=1" → EventController::show() with $_GET['id'] = 1
   * - "user/login" → UserController::login()
   * - "admin/overview" → AdminController::overview()
   */
  private static function handle() {
    // Create router instance (autoloader will load Router.php)
    $router = new Router();
    
    /**
     * Pass the query string to router for parsing
     * $_SERVER["QUERY_STRING"] contains everything after the ? in URL
     * 
     * URL: Index.php?event/show&id=1
     * Query string: "event/show&id=1"
     * 
     * The router will:
     * 1. Parse "event/show" to get controller and action
     * 2. Leave "&id=1" in $_GET array
     */
    $router->dispatch($_SERVER["QUERY_STRING"] ?? '');
  }
}

/**
 * START THE APPLICATION!
 * This is the ONLY line of code that actually executes when this file is loaded.
 * Everything else above is class/method definitions.
 * 
 * Execution flow:
 * 1. This line calls Index::run()
 * 2. run() calls init() to set up environment
 * 3. run() calls handle() to process the request
 * 4. handle() creates Router and dispatches
 * 5. Router finds and calls appropriate Controller
 * 6. Controller renders View
 * 7. Response sent to browser
 */
Index::run();
