<?php
/**
 * UserController.php - User Authentication and Management
 * 
 * Handles all user-related operations including:
 * - Login and authentication
 * - User registration
 * - Logout and session management
 * - Protected page access (welcome, admin)
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class UserController
 * 
 * Controller responsible for user authentication, registration,
 * and access to user-specific pages.
 */
class UserController extends Controller
{
    /**
     * @var UserModel $userModel Instance of UserModel for database operations
     */
    private $userModel;
    
    /**
     * @var EventModel $eventModel Instance of EventModel for event-related operations
     */
    private $eventModel;

    /**
     * UserController constructor
     * 
     * Initializes session management and model instances.
     * Checks for session expiration and destroys expired sessions.
     */
    public function __construct()
    {
        Session::start();
        
        // Check if session expired (for protected pages)
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
        
        $this->userModel = new UserModel();
        $this->eventModel = new EventModel();
    }

    /* ---------- Authentication Methods ---------- */

    /**
     * Display login form and handle login submissions
     * 
     * GET: Displays the login form
     * POST: Processes login credentials and authenticates user
     * 
     * On successful login:
     * - Stores user data in session
     * - Redirects admins to /event/all
     * - Redirects regular users to /attendee/dashboard
     * 
     * @return void
     */
    public function login()
    {
        // If already logged in, redirect based on role
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role_name'] === 'admin') {
                header('Location: ' . PROJECT_URL . '/event/all');
            } else {
                header('Location: ' . PROJECT_URL . '/attendee/dashboard');
            }
            exit;
        }

        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Attempt authentication
            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                // Store user data in session
                $_SESSION['user'] = $user;

                // Redirect based on role
                if ($user['role_name'] === 'admin') {
                    header('Location: ' . PROJECT_URL . '/event/all');
                } else {
                    header('Location: ' . PROJECT_URL . '/attendee/dashboard');
                }
                exit;
            }

            // Authentication failed - show error
            $this->view(['error' => 'Invalid username or password']);
            return;
        }

        // Show login form (GET request)
        $this->view();
    }

    /**
     * Display registration form and handle registration submissions
     * 
     * GET: Displays the registration form with role options
     * POST: Processes new user registration
     * 
     * All new users are registered as attendees (role_id = 2) by default.
     * On successful registration, redirects to login page.
     * 
     * @return void
     */
    public function register()
    {
        // Handle registration form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name'  => trim($_POST['last_name'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'username'   => trim($_POST['username'] ?? ''),
                'password'   => trim($_POST['password'] ?? ''),
                'role_id'    => (int)($_POST['role_id'] ?? 2),  // Default to attendee
            ];

            // Attempt registration
            $result = $this->userModel->register($data);

            if ($result === true) {
                // Registration successful - redirect to login
                header('Location: ' . PROJECT_URL . '/user/login');
                exit;
            }

            // Registration failed - show error with roles
            $roles = $this->userModel->getRoles();
            $this->view([
                'error' => $result ?: 'Registration failed.',
                'roles' => $roles
            ]);
            return;
        }

        // Show registration form (GET request)
        $roles = $this->userModel->getRoles();
        $this->view(['roles' => $roles]);
    }

    /**
     * Handle user logout
     * 
     * Destroys the current session and redirects to login page.
     * Uses Session::destroy() which handles all cleanup including
     * session data, cookies, and session files.
     * 
     * @return void (exits via redirect)
     */
    public function logout()
    {
        Session::destroy();
    }

    /* ---------- Protected Pages ---------- */

    /**
     * Display welcome page (protected)
     * 
     * A generic protected page accessible to all authenticated users.
     * Redirects to login if user is not authenticated.
     * 
     * @return void
     */
    public function welcome()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }
        $this->view(['user' => $_SESSION['user']]);
    }

    /**
     * Display admin page (admin only)
     * 
     * A protected page accessible only to users with admin role.
     * Redirects to login if user is not authenticated or not an admin.
     * 
     * @return void
     */
    public function admin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }
        $this->view(['user' => $_SESSION['user']]);
    }
}
