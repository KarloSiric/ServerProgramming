<?php
// User authentication and profile endpoints - clean auto-resolving actions  
class UserController extends Controller
{
    // Login form - auto-resolves to app/view/user/login.php
    public function login() {
        if (!empty($_SESSION['user'])) {
            $this->redirect('user/dashboard');
        }
        
        $this->view([
            'title' => 'EventHorizon - Beyond the Edge of Events',
            'error' => $_SESSION['flash_error'] ?? null,
        ]);
        unset($_SESSION['flash_error']);
    }
    
    // Registration form - auto-resolves to app/view/user/register.php  
    public function register() {
        if (!empty($_SESSION['user'])) {
            $this->redirect('user/dashboard');
        }
        
        $this->view([
            'title' => 'Create Account - EventHorizon',
            'error' => $_SESSION['flash_error'] ?? null,
            'success' => $_SESSION['flash_success'] ?? null,
        ]);
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }
    
    // User dashboard - auto-resolves to app/view/user/attendee_dashboard.php for regular users
    public function dashboard() {
        $this->requireLogin();
        $user = $this->userOrNull();
        
        // Redirect admin users to their dashboard
        if (($user['role'] ?? '') === 'admin') {
            $this->redirect('admin/overview');
        }
        
        // Load events for regular users
        $model = $this->model();
        $events = $model->getAllEvents();
        
        $this->view([
            'title' => 'EventHorizon - Beyond the Edge of Events',
            'user' => $user,
            'events' => $events
        ]);
    }
    
    // Attendees page - auto-resolves to app/view/user/attendees.php
    public function attendees() {
        $this->requireLogin();
        
        $this->view([
            'title' => 'Attendees - EventHorizon',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // Process user registration
    public function createAccount() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $isAdmin = isset($_POST['admin_role']);
        
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['flash_error'] = 'All fields are required.';
            $this->redirect('user/register');
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['flash_error'] = 'Passwords do not match.';
            $this->redirect('user/register');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Please enter a valid email address.';
            $this->redirect('user/register');
        }
        
        $model = $this->model();
        $success = $model->createUser($name, $email, $password, $isAdmin);
        
        if ($success) {
            $_SESSION['flash_success'] = 'Account created successfully! You can now sign in.';
            $this->redirect('user/login');
        } else {
            $_SESSION['flash_error'] = 'Email already exists. Please use a different email.';
            $this->redirect('user/register');
        }
    }
    
    // Process user login
    public function authenticate() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $model = $this->model();
        $user = $model->authenticate($username, $password);
        
        if ($user === null) {
            $_SESSION['flash_error'] = 'Invalid username or password.';
            $this->redirect('user/login');
        }
        
        $_SESSION['user'] = $user;
        $this->redirect('user/dashboard');
    }
    
    // Logout and redirect - clean session destruction like your friend's approach
    public function logout() {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $cookieParams = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $cookieParams["path"], $cookieParams["domain"],
                $cookieParams["secure"], $cookieParams["httponly"]
            );
        }
        
        session_destroy();
        $this->redirect('user/login');
    }
}
