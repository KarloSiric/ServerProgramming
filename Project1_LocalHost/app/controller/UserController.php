<?php
// UserController.php - Enhanced with registration and admin functions
class UserController extends Controller
{
    private UserModel $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    // GET /user/login - Show login form
    public function login($params = []): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect('/user/dashboard');
        }
        
        $this->render('user/login.php', [
            'title' => 'EventHorizon - Beyond the Edge of Events',
            'error' => $_SESSION['flash_error'] ?? null,
        ]);
        unset($_SESSION['flash_error']);
    }
    
    // GET /user/register - Show registration form
    public function register($params = []): void
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect('/user/dashboard');
        }
        
        $this->render('user/register.php', [
            'title' => 'Create Account - EventHorizon',
            'error' => $_SESSION['flash_error'] ?? null,
            'success' => $_SESSION['flash_success'] ?? null,
        ]);
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }
    
    // POST /user/createAccount - Process registration
    public function createAccount($params = []): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $isAdmin = isset($_POST['admin_role']);
        
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['flash_error'] = 'All fields are required.';
            $this->redirect('/user/register');
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['flash_error'] = 'Passwords do not match.';
            $this->redirect('/user/register');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Please enter a valid email address.';
            $this->redirect('/user/register');
        }
        
        $success = $this->userModel->createUser($name, $email, $password, $isAdmin);
        if ($success) {
            $_SESSION['flash_success'] = 'Account created successfully! You can now sign in.';
            $this->redirect('/user/login');
        } else {
            $_SESSION['flash_error'] = 'Email already exists. Please use a different email.';
            $this->redirect('/user/register');
        }
    }
    
    // POST /user/authenticate - Process login
    public function authenticate($params = []): void
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = $this->userModel->authenticate($username, $password);
        if ($user === null) {
            $_SESSION['flash_error'] = 'Invalid username or password.';
            $this->redirect('/user/login');
        }
        
        $_SESSION['user'] = $user;
        $this->redirect('/user/dashboard');
    }
    
    // GET /user/dashboard - Show role-based dashboard
    public function dashboard($params = []): void
    {
        $this->requireLogin();
        $user = $this->userOrNull();
        
        if (($user['role'] ?? '') === 'admin') {
            $this->redirect('/admin/overview');
        } else {
            $this->render('user/attendee_dashboard.php', [
                'title' => 'EventHorizon - Beyond the Edge of Events',
                'user' => $user,
            ]);
        }
    }
    
    // GET /user/attendees - Show attendees page
    public function attendees($params = []): void
    {
        $this->requireLogin();
        $user = $this->userOrNull();
        
        $this->render('user/attendees.php', [
            'title' => 'Attendees - EventHorizon',
            'user' => $user,
        ]);
    }
    
    // GET /user/logout - Logout and destroy session
    public function logout($params = []): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $cookieParams = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $cookieParams["path"], $cookieParams["domain"],
                $cookieParams["secure"], $cookieParams["httponly"]
            );
        }
        session_destroy();
        $this->redirect('/user/login');
    }
}
