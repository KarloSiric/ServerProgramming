<?php
/**
 * @file Router.php
 * @brief URL routing system for the EventHorizon application
 * 
 * This router implements a simple but effective URL parsing system using regex.
 * It maps URL patterns to Controller/Action pairs following MVC pattern.
 * 
 * @author KarloSiric
 * @version 1.0
 * @date 2025
 * 
 * @details URL Format: ?controller/action/param1/param2&key=value
 * - controller: The controller to use (e.g., 'event')
 * - action: The method to call (e.g., 'show')
 * - params: Optional parameters (e.g., '1', 'edit')
 * - &key=value: Additional GET parameters
 * 
 * @example
 * - ?event/show/1 → EventController::show(['1'])
 * - ?user/login → UserController::login()
 * - ?admin/events&page=2 → AdminController::events() with $_GET['page'] = 2
 */

/**
 * @class Router
 * @brief Handles URL routing and request dispatching
 * 
 * Parses URLs in the format: ?controller/action/param1/param2&key=value
 * Maps these to Controller classes and their methods.
 * 
 * @note This is a tiny but powerful regex-based router
 * @note Final class - cannot be extended
 */
final class Router {
  /**
   * @var string $pattern Regex pattern for parsing URLs
   * 
   * Pattern breakdown:
   * - ^ : Start of string
   * - (?<controller>[a-z]+) : Capture lowercase letters as 'controller'
   * - \/ : Forward slash separator
   * - (?<action>[a-z]+) : Capture lowercase letters as 'action'
   * - (?<params>[\/\d+]*) : Optional: capture slash + digits as 'params'
   * - \/? : Optional trailing slash
   * - $ : End of string
   * 
   * @internal Named capture groups make the regex self-documenting
   */
  private string $pattern = "/^(?<controller>[a-z]+)\/(?<action>[a-z]+)(?<params>[\/\d+]*)\/?$/";
  
  /**
   * @var string $controller Name of the controller class to instantiate
   * @internal Defaults to 'SiteController' for home page
   */
  private string $controller = "SiteController";
  
  /**
   * @var string $action Name of the method to call on the controller
   * @internal Defaults to 'home' action
   */
  private string $action = "home";
  
  /**
   * @var array $params Additional URL parameters passed to action
   * @internal Example: /event/show/1/edit → params = ['1', 'edit']
   */
  private array $params = [];

  /**
   * @brief Main routing method - processes request and calls appropriate controller
   * 
   * @param string|null $query The query string from URL (e.g., "event/show&id=1")
   * 
   * @throws Exception If controller class not found
   * @throws Exception If action method not found on controller
   * 
   * @details Processing steps:
   * 1. Extract route part (before &) from query string
   * 2. Parse route to get controller/action/params
   * 3. Handle special cases (e.g., event/view → event/show)
   * 4. Instantiate controller class
   * 5. Check if action method exists
   * 6. Call action method with params if applicable
   * 
   * @note Called by Index::handle()
   * @see Index::handle()
   * 
   * @example Query: "event/show&id=1"
   * 1. Split on & → "event/show"
   * 2. Parse → controller='EventController', action='show'
   * 3. $_GET keeps 'id' => 1
   * 4. Call EventController->show()
   */
  public function dispatch(?string $query) {
    /**
     * Split query on & to separate route from GET parameters
     * Example: "event/show&id=1" becomes "event/show"
     * The id=1 part stays in $_GET array automatically
     * 
     * explode('&', $query, 2) means:
     * - Split on first & only
     * - Maximum 2 parts
     * - Extra & characters are preserved in second part
     */
    $routePart = $query ? explode('&', $query, 2)[0] : '';

    // Parse the route part and extract controller/action/params
    if ($routePart && ($p = $this->parse($routePart))) {
      $this->controller = $p['controller'];
      $this->action     = $p['action'];
      $this->params     = $p['params'] ?? [];
      
      /**
       * Handle action aliases
       * Some URLs use different action names for user-friendliness
       * Example: /event/view is more intuitive than /event/show
       * 
       * This allows both URLs to work:
       * - /event/view&id=1 (user-friendly)
       * - /event/show&id=1 (internal)
       */
      if ($this->controller === 'EventController' && $this->action === 'view') {
        $this->action = 'show';  // Internally use 'show' action
      }
    }
    // If no route or parse fails, defaults remain (SiteController::home)

    /**
     * Verify controller class exists
     * The autoloader (Index::loadClass) will try to load it
     * from app/controller/ControllerName.php
     */
    if (!class_exists($this->controller)) {
      throw new Exception("Controller {$this->controller} not found");
    }

    // Instantiate the controller
    $c = new $this->controller();

    /**
     * Verify the action method exists and is callable
     * is_callable checks:
     * 1. Method exists on the object
     * 2. Method is public
     * 3. Method is not static (when called with array syntax)
     */
    if (!is_callable([$c, $this->action])) {
      throw new Exception("Action {$this->action} not found on {$this->controller}");
    }

    /**
     * Use reflection to check if action accepts parameters
     * This prevents errors when calling methods that don't expect params
     * 
     * Example:
     * - show($params) can receive params
     * - home() cannot receive params
     * 
     * ReflectionMethod allows introspection of method signatures
     */
    $ref = new ReflectionMethod($c, $this->action);
    if (!empty($this->params) && $ref->getNumberOfParameters() > 0) {
      // Call action with params array
      $c->{$this->action}($this->params);
    } else {
      // Call action without params
      $c->{$this->action}();
    }
  }

  /**
   * @brief Parse URL string into controller/action/params
   * 
   * @param string $q URL query string to parse (e.g., "event/show/1")
   * @return array|false Associative array with controller/action/params or false on failure
   * 
   * @internal Uses regex to extract URL components
   * 
   * @details Return array structure:
   * - 'controller': ControllerClass name (e.g., 'EventController')
   * - 'action': method name (e.g., 'show')
   * - 'params': array of additional parameters (e.g., ['1', 'edit'])
   * 
   * @example Input: "event/show/1"
   * Output: [
   *   'controller' => 'EventController',
   *   'action' => 'show',
   *   'params' => ['1']
   * ]
   * 
   * @note Controller name is ucfirst + 'Controller' suffix
   */
  private function parse(string $q) {
    // Apply regex pattern to extract components
    if (preg_match($this->pattern, $q, $m)) {
      return [
        /**
         * Convert 'event' to 'EventController'
         * ucfirst('event') = 'Event'
         * 'Event' . 'Controller' = 'EventController'
         */
        'controller' => ucfirst($m['controller']) . 'Controller',
        
        // Action stays as-is (lowercase)
        'action'     => $m['action'],
        
        /**
         * Split params on "/" and remove leading slash
         * Example: "/1/edit" becomes ['1', 'edit']
         * ltrim removes leading characters
         */
        'params'     => explode("/", ltrim($m['params'] ?? '', "/")),
      ];
    }
    return false;  // Pattern didn't match - will use defaults
  }
}
