<?php
// UserController.php - Enhanced with registration and admin functions (Server compatible)
class UserController extends Controller
{
    private UserModel $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    // GET /user/login - Show login form
    public function login(): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect('user/dashboard');
        }
        
        $this->render('user/login.php', [
            'title' => 'EventHorizon - Beyond the Edge of Events',
            'error' => $_SESSION['flash_error'] ?? null,
        ]);
        unset($_SESSION['flash_error']);
    }
    
    // GET /user/register - Show registration form
    public function register(): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect('user/dashboard');
        }
        
        $this->render('user/register.php', [
            'title' => 'Create Account - EventHorizon',
            'error' => $_SESSION['flash_error'] ?? null,
            'success' => $_SESSION['flash_success'] ?? null,
        ]);
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }
    
    // POST /user/authenticate - Process login
    public function authenticate(): void
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['flash_error'] = 'Please enter both username and password.';
            $this->redirect('user/login');
        }
        
        $user = $this->userModel->authenticate($username, $password);
        
        if ($user) {
            $_SESSION['user'] = $user;
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                $this->redirect('admin/overview');
            } else {
                $this->redirect('user/dashboard');
            }
        } else {
            $_SESSION['flash_error'] = 'Invalid username or password.';
            $this->redirect('user/login');
        }
    }
    
    // POST /user/createAccount - Process registration
    public function createAccount(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        
        // Validation
        if (empty($username) || empty($email) || empty($name) || empty($password)) {
            $_SESSION['flash_error'] = 'Please fill in all required fields.';
            $this->redirect('user/register');
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['flash_error'] = 'Passwords do not match.';
            $this->redirect('user/register');
        }
        
        if (strlen($password) < 6) {
            $_SESSION['flash_error'] = 'Password must be at least 6 characters long.';
            $this->redirect('user/register');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Please enter a valid email address.';
            $this->redirect('user/register');
        }
        
        // Check if user already exists
        if ($this->userModel->userExists($username, $email)) {
            $_SESSION['flash_error'] = 'Username or email already exists.';
            $this->redirect('user/register');
        }
        
        // Create user
        if ($this->userModel->createUser($username, $email, $name, $password, $role)) {
            $_SESSION['flash_success'] = 'Account created successfully! You can now sign in.';
            $this->redirect('user/login');
        } else {
            $_SESSION['flash_error'] = 'Failed to create account. Please try again.';
            $this->redirect('user/register');
        }
    }
    
    // GET /user/dashboard - Show user dashboard
    public function dashboard(): void
    {
        $this->requireLogin();
        
        $user = $this->userOrNull();
        $eventModel = new EventModel();
        $events = $eventModel->getAllEvents();
        
        $this->render('user/dashboard.php', [
            'title' => 'Dashboard - EventHorizon',
            'user' => $user,
            'events' => $events,
        ]);
    }
    
    // GET /user/attendees - Show attendees page
    public function attendees(): void
    {
        $this->requireLogin();
        
        $user = $this->userOrNull();
        
        $this->render('user/attendees.php', [
            'title' => 'Attendees - EventHorizon',
            'user' => $user,
        ]);
    }
    
    // GET /user/logout - Logout user
    public function logout(): void
    {
        session_destroy();
        $this->redirect('user/login');
    }
}
