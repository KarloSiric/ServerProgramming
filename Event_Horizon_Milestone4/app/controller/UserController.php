<?php

class UserController extends Controller
{
    private $userModel;
    private $eventModel;

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

    /* ---------- Auth ---------- */

    public function login()
    {
        // If already logged in, redirect
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role_name'] === 'admin') {
                header('Location: ' . PROJECT_URL . '/event/all');
            } else {
                header('Location: ' . PROJECT_URL . '/attendee/dashboard');
            }
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                // Redirect based on role
                if ($user['role_name'] === 'admin') {
                    header('Location: ' . PROJECT_URL . '/event/all');
                } else {
                    header('Location: ' . PROJECT_URL . '/attendee/dashboard');
                }
                exit;
            }

            $this->view(['error' => 'Invalid username or password']);
            return;
        }

        $this->view();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name'  => trim($_POST['last_name'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'username'   => trim($_POST['username'] ?? ''),
                'password'   => trim($_POST['password'] ?? ''),
                'role_id'    => (int)($_POST['role_id'] ?? 2),
            ];

            $result = $this->userModel->register($data);

            if ($result === true) {
                header('Location: ' . PROJECT_URL . '/user/login');
                exit;
            }

            $roles = $this->userModel->getRoles();
            $this->view([
                'error' => $result ?: 'Registration failed.',
                'roles' => $roles
            ]);
            return;
        }

        $roles = $this->userModel->getRoles();
        $this->view(['roles' => $roles]);
    }

    public function logout()
    {
        Session::destroy();
    }

    /* ---------- Pages ---------- */

    public function welcome()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }
        $this->view(['user' => $_SESSION['user']]);
    }

    public function admin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }
        $this->view(['user' => $_SESSION['user']]);
    }
}
