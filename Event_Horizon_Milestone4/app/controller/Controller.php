<?php
/**
 * Controller.php - Base Controller Class
 * 
 * Abstract base class for all controller classes in the application.
 * Provides common functionality for loading views with data.
 * 
 * All controllers should extend this class to inherit the view
 * rendering functionality.
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class Controller
 * 
 * Base controller class that provides view rendering capabilities
 * to all child controller classes.
 */
class Controller
{
    /**
     * Load and render a view
     * 
     * Loads the appropriate view file based on the calling controller and method.
     * Automatically includes header and footer templates, and extracts data array
     * into individual variables for use in the view.
     * 
     * View file location is determined by:
     * - Controller name (e.g., UserController -> user)
     * - Action name (e.g., login -> login.php)
     * - Final path: app/view/user/login.php
     * 
     * @param array $data Associative array of data to pass to the view
     * @return void
     */
    protected function view($data = [])
    {
        // Determine controller and action names from backtrace
        $trace = debug_backtrace();
        $controller = strtolower(str_replace('Controller', '', get_class($this)));
        $action = $trace[0]['function'];

        // Build view file path
        $viewFile = "app/view/{$controller}/{$action}.php";

        // Extract data array into individual variables
        extract($data);

        // Include header, view, and footer
        require_once 'app/view/inc/header.php';
        require_once $viewFile;
        require_once 'app/view/inc/footer.php';
    }
}
