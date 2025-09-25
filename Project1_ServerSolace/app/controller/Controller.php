<?php
/**
 * @file Controller.php
 * @brief Base controller class for MVC pattern implementation
 * 
 * All controllers in the application extend this base class.
 * Provides common functionality for loading models, rendering views,
 * and enforcing role-based access control.
 * 
 * @author KarloSiric
 * @version 1.0
 * @date 2024
 * 
 * @details Controller Responsibilities:
 * 1. Process user input from requests
 * 2. Load and interact with models for data
 * 3. Pass data to views for rendering
 * 4. Handle authentication/authorization
 * 5. Redirect users as needed
 */

/**
 * @class Controller
 * @brief Abstract base controller providing core MVC functionality
 * 
 * Features:
 * - Automatic model resolution (FooController → FooModel)
 * - View rendering with data passing
 * - Role-based access control
 * - Shared header/footer layout system
 * 
 * @note All controllers MUST extend this class
 * @note Not marked abstract to allow instantiation for testing
 */
class Controller {
  /**
   * @brief Get the model instance for this controller
   * 
   * Uses naming convention to automatically resolve model class:
   * - EventController → EventModel
   * - UserController → UserModel
   * - AdminController → AdminModel
   * If specific model doesn't exist, falls back to AppModel
   * 
   * @return Model Instance of the appropriate model class
   * 
   * @details Resolution Process:
   * 1. Get current controller class name (e.g., 'EventController')
   * 2. Replace 'Controller' with 'Model' (e.g., 'EventModel')
   * 3. Check if that model class exists
   * 4. If not, use AppModel as fallback
   * 5. Instantiate and return the model
   * 
   * @example Usage in EventController:
   * ```php
   * public function show() {
   *   $m = $this->model();        // Gets EventModel or AppModel
   *   $events = $m->events();     // Call model method
   * }
   * ```
   * 
   * @note AppModel is the fallback for demo data when no DB exists
   * @see AppModel For demo data structure
   */
  public function model() {
    // Replace "Controller" with "Model" in class name
    // get_class($this) returns current class (e.g., 'EventController')
    $model = str_replace("Controller", "Model", get_class($this));
    
    // Check if specific model exists, otherwise use AppModel
    // class_exists triggers autoloader to look for the class
    if (!class_exists($model)) {
      $model = 'AppModel'; // Fallback to demo data model
    }
    
    // Create and return model instance
    return new $model();
  }

  /**
   * @brief Render a view with optional data
   * 
   * @param array $data Associative array of data to pass to view
   * 
   * @throws Exception If view file not found
   * 
   * @details View Resolution Process:
   * 1. Extract data array into individual variables
   * 2. Determine view path from controller/action names
   * 3. Include header.php (navigation, CSS, opening HTML)
   * 4. Include the specific view file
   * 5. Include footer.php (closing HTML, scripts)
   * 
   * @example Path Resolution:
   * - EventController::show() → app/view/event/show.php
   * - UserController::login() → app/view/user/login.php
   * - AdminController::overview() → app/view/admin/overview.php
   * 
   * @note Data extraction example:
   * ```php
   * // In controller:
   * $this->view(['event' => $eventData, 'user' => $userData]);
   * 
   * // In view, these variables are available:
   * echo $event['name'];  // Works!
   * echo $user['email'];  // Works!
   * ```
   * 
   * @warning Variables in $data can overwrite existing variables
   * @see app/view/inc/header.php For page header
   * @see app/view/inc/footer.php For page footer
   */
  public function view($data = []) {
    /**
     * Extract data array to variables
     * extract(['event' => $e, 'venues' => $v])
     * Creates: $event = $e; $venues = $v;
     * 
     * This makes data available in view files naturally
     */
    if (!empty($data)) {
      extract($data);
    }
    
    /**
     * Resolve view file path from controller/action names
     * 
     * get_called_class() returns the actual class (not 'Controller')
     * Example: 'EventController'
     * 
     * str_replace removes 'Controller' → 'Event'
     * strtolower → 'event'
     */
    $controller = strtolower(str_replace('Controller', '', get_called_class()));
    
    /**
     * debug_backtrace() gets the call stack
     * [0] is current function (view)
     * [1] is calling function (e.g., 'show')
     * 
     * This clever trick gets the action name automatically
     */
    $action = debug_backtrace()[1]['function'];
    
    // Build view file path
    $tpl = "app/view/{$controller}/{$action}.php";
    
    // Verify view file exists
    if (!file_exists($tpl)) {
      throw new Exception("Missing view: $tpl");
    }

    /**
     * Render the complete page in order:
     * 1. header.php - Sets up HTML, loads CSS, creates navigation
     * 2. $tpl - The actual view content (forms, lists, etc.)
     * 3. footer.php - Closes HTML, loads JavaScript
     * 
     * Variables available in all three files:
     * - All extracted $data variables
     * - $user (from session, set in header)
     * - $events, $venues, $users (from AppModel, set in header)
     */
    require 'app/view/inc/header.php';
    require $tpl;
    require 'app/view/inc/footer.php';
  }

  /**
   * @brief Enforce role-based access control
   * 
   * @param string $role Required role (e.g., 'admin', 'attendee')
   * 
   * @details Security check for protected routes:
   * 1. Get user's role from session
   * 2. Compare against required role
   * 3. If match: continue execution
   * 4. If no match: show 403 error and stop
   * 
   * @note Usage in AdminController:
   * ```php
   * public function dashboard() {
   *   $this->requireRole('admin');  // Only admins past this point
   *   // Admin-only code here
   *   $this->view();
   * }
   * ```
   * 
   * @warning This method calls exit() if authorization fails
   * @warning Execution STOPS completely on auth failure
   * 
   * @see $_SESSION['user']['role'] Set during login
   * @see UserController::authenticate() Where role is assigned
   */
  protected function requireRole(string $role) {
    /**
     * Get current user's role from session
     * Default to 'guest' if not logged in
     * 
     * ?? is null coalescing operator:
     * - If $_SESSION['user']['role'] exists, use it
     * - Otherwise use 'guest'
     */
    $r = $_SESSION['user']['role'] ?? 'guest';
    
    // Check if user has required role (exact match required)
    if ($r !== $role) {
      // Send 403 Forbidden HTTP status code
      http_response_code(403);
      
      /**
       * Render error page with header/footer
       * This maintains consistent site appearance even for errors
       */
      require 'app/view/inc/header.php';
      echo "<div class='alert alert-danger mt-3'>403 – {$role} required</div>";
      require 'app/view/inc/footer.php';
      
      /**
       * Stop execution immediately
       * Critical for security - prevents any further code execution
       * Without this, protected code would still run!
       */
      exit;
    }
    // If role matches, function returns and execution continues normally
  }
}
