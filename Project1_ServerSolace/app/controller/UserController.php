<?php
/**
 * @file UserController.php
 * @brief Controller handling user authentication and account management
 * 
 * Manages login, logout, registration, and user dashboards.
 * Implements demo authentication for development/testing.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Authentication is demo-only for Milestone 1/2
 * @todo Implement real authentication with password hashing
 */

/**
 * @class UserController
 * @brief Handles all user-related actions
 * 
 * URL mappings:
 * - /user/login → Show login form
 * - /user/authenticate → Process login (POST)
 * - /user/logout → End session
 * - /user/register → Show registration form
 * - /user/createaccount → Process registration (POST)
 * - /user/dashboard → User home page
 * - /user/welcome → Welcome page after login
 * - /user/attendees → List all attendees
 */
class UserController extends Controller {
  
  /**
   * @brief Display login form
   * 
   * @return void
   * 
   * @details Renders login form for user authentication
   * @note Public access - no authentication required
   * @see app/view/user/login.php
   */
  public function login() { 
    $this->view(); 
  }
  
  /**
   * @brief Display registration form
   * 
   * @return void
   * 
   * @details Shows form for new user registration
   * @note Public access - no authentication required
   * @see app/view/user/register.php
   */
  public function register() { 
    $this->view(); 
  }
  
  /**
   * @brief Process login form submission (demo authentication)
   * 
   * @return void
   * 
   * @details Demo authentication logic:
   * 1. Username "admin" → Admin role
   * 2. Any other username → Attendee role
   * 3. No actual password verification (demo only)
   * 
   * Session data created:
   * - first_name: User's first name
   * - last_name: User's last name
   * - name: Full display name
   * - username: Login username
   * - email: User's email
   * - role: 'admin' or 'attendee'
   * 
   * @note POST endpoint - called by login form
   * @warning This is NOT secure - demo only!
   * @todo Implement real authentication with bcrypt
   */
  public function authenticate() {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Demo auth: admin username gets admin role, everything else is attendee
    if (strtolower($username) === 'admin') {
      // Create admin session
      $_SESSION['user'] = [
        'first_name' => 'Admin',
        'last_name' => 'User',
        'name' => 'Admin User',
        'username' => $username,
        'email' => 'admin@eventhorizon.com',
        'role' => 'admin'
      ];
      // Redirect to admin dashboard
      header('Location: ' . PROJECT_URL . '/Index.php?admin/overview');
    } else {
      // Create attendee session
      $_SESSION['user'] = [
        'first_name' => 'Event',
        'last_name' => 'Attendee',
        'name' => $username,
        'username' => $username,
        'email' => $username . '@eventhorizon.com',
        'role' => 'attendee'
      ];
      // Redirect to user dashboard
      header('Location: ' . PROJECT_URL . '/Index.php?user/dashboard');
    }
    exit;
  }
  
  /**
   * @brief Process registration form submission
   * 
   * @return void
   * 
   * @details Creates new user account (demo only):
   * 1. Extract form data (name, email)
   * 2. Check if admin role requested
   * 3. Create session (auto-login)
   * 4. Redirect to dashboard
   * 
   * @note POST endpoint - called by register form
   * @warning Demo only - doesn't save to database
   * @todo Implement actual user creation in database
   * @todo Add email verification
   * @todo Add password strength requirements
   */
  public function createaccount() {
    $name = trim($_POST['name'] ?? 'New User');
    $email = trim($_POST['email'] ?? '');
    $isAdmin = isset($_POST['admin_role']);
    
    // Demo registration - just create session
    $_SESSION['user'] = [
      'first_name' => $name,
      'last_name' => '',
      'name' => $name,
      'username' => explode('@', $email)[0],  // Use email prefix as username
      'role' => $isAdmin ? 'admin' : 'attendee'
    ];
    
    // Show success message if flash function available
    if (function_exists('flash')) {
      flash('success', 'Account created successfully!');
    }
    
    // Auto-login and redirect to dashboard
    header('Location: ' . PROJECT_URL . '/Index.php?user/dashboard');
    exit;
  }
  
  /**
   * @brief End user session and logout
   * 
   * @return void
   * 
   * @details Logout process:
   * 1. Clear all session data
   * 2. Destroy the session
   * 3. Redirect to home page
   * 
   * @note Accessible by: Any logged-in user
   */
  public function logout() {
    // Clear session array
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
    
    // Redirect to home
    header('Location: ' . PROJECT_URL . '/Index.php');
    exit;
  }
  
  /**
   * @brief Display user dashboard
   * 
   * @return void
   * 
   * @details Main user home page showing:
   * - Welcome message
   * - Event statistics
   * - Available events grid
   * - Registration options
   * 
   * @note Restricted to: Logged-in users
   * @see app/view/user/dashboard.php
   */
  public function dashboard() { 
    $this->view(); 
  }
  
  /**
   * @brief Display welcome page
   * 
   * @return void
   * 
   * @details Post-login welcome page
   * Shows role-specific information and options
   * 
   * @note Restricted to: Logged-in users
   * @see app/view/user/welcome.php
   */
  public function welcome() { 
    $this->view(); 
  }
  
  /**
   * @brief Display attendee list
   * 
   * @return void
   * 
   * @details Shows list of all event attendees
   * May be restricted to certain roles
   * 
   * @note Potentially restricted view
   * @see app/view/user/attendees.php
   */
  public function attendees() { 
    $this->view(); 
  }
  
  /**
   * @brief Display admin-specific dashboard
   * 
   * @return void
   * 
   * @details Admin dashboard with management options
   * @note Restricted to: Admin users only
   * @see app/view/user/admin_dashboard.php
   */
  public function admin_dashboard() { 
    $this->requireRole('admin');
    $this->view(); 
  }
  
  /**
   * @brief Display attendee-specific dashboard
   * 
   * @return void
   * 
   * @details Attendee dashboard with event options
   * @note Restricted to: Attendee users
   * @see app/view/user/attendee_dashboard.php
   */
  public function attendee_dashboard() { 
    $this->requireRole('attendee');
    $this->view(); 
  }
}
