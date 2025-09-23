<?php

/**
 * EventHorizon Front Controller
 * Bootstraps the application and handles all incoming requests
 * 
 * @author Kristina Marasovic <kristina.marasovic@croatia.rit.edu>
 */
final class Index {

    public static function run() { 
        self::init(); 
        self::handle(); 
    }

    private static function init() {
        // Force error display for debugging
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
        // Start session if needed
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Define application constants
        define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));
        define('TITLE', 'EventHorizon · MVC');

        // Set up autoloader
        spl_autoload_register(['Index', 'loadClass']);
    }

    private static function loadClass($className) {
        $directories = [
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/filter/',
            'app/db/'
        ];
        
        foreach ($directories as $directory) {
            $filePath = $directory . $className . '.php';
            if (file_exists($filePath)) { 
                require_once $filePath; 
                return true; 
            }
        }
        return false;
    }

    private static function handle() {
        try {
            // Get the query string, but handle empty/null cases
            $queryString = $_SERVER["QUERY_STRING"] ?? '';
            
            // If no query string is provided, redirect to a sensible default
            if (empty($queryString)) {
                // Check if user is already logged in
                if (isset($_SESSION['user'])) {
                    // Logged in users go to their appropriate dashboard
                    $userRole = $_SESSION['user']['role'] ?? 'user';
                    if ($userRole === 'admin') {
                        header("Location: ?admin/overview");
                    } else {
                        header("Location: ?user/dashboard");
                    }
                } else {
                    // Non-logged-in users go to login page
                    header("Location: ?user/login");
                }
                exit;
            }
            
            // Create and dispatch through router
            $router = new Router();
            $router->dispatch($queryString);
            
        } catch (Exception $e) {
            // Show detailed error information for debugging
            self::showError($e->getMessage(), $e);
        } catch (Error $e) {
            // Handle fatal errors that might occur
            self::showError("Fatal Error: " . $e->getMessage(), $e);
        }
    }
    
    private static function showError($message, $exception = null) {
        http_response_code(500);
        echo "<!DOCTYPE html>";
        echo "<html><head><title>EventHorizon - System Error</title>";
        echo "<style>";
        echo "body{font-family:Arial,sans-serif;margin:40px;background:#f8f9fa;}";
        echo ".error{background:#f8d7da;border:1px solid #f5c6cb;padding:20px;border-radius:8px;color:#721c24;}";
        echo ".debug{background:#fff3cd;border:1px solid #ffeaa7;padding:15px;border-radius:8px;color:#856404;margin-top:15px;}";
        echo "pre{background:#f8f9fa;padding:10px;border-radius:4px;overflow-x:auto;}";
        echo "</style></head><body>";
        echo "<h1>EventHorizon - System Error</h1>";
        echo "<div class='error'><strong>Error:</strong> " . htmlspecialchars($message) . "</div>";
        
        // Show debug information if we have an exception
        if ($exception && method_exists($exception, 'getFile')) {
            echo "<div class='debug'>";
            echo "<strong>Debug Information:</strong><br>";
            echo "<strong>File:</strong> " . htmlspecialchars($exception->getFile()) . "<br>";
            echo "<strong>Line:</strong> " . $exception->getLine() . "<br>";
            echo "<strong>Stack Trace:</strong><br>";
            echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
            echo "</div>";
        }
        
        echo "<p><a href='?user/login'>← Return to Login</a> | <a href='/~ks9700/iste-341/Project1/diagnostic.php'>Run Diagnostic</a></p>";
        echo "</body></html>";
    }
}

// Run the application
Index::run();
