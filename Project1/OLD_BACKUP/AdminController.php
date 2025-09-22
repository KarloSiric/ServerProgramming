<?php

/**
 * Admin Controller for EventPro
 * Handles admin-specific functionality
 * 
 * @author Student Implementation
 */
class AdminController extends Controller {
    
    /**
     * Constructor - Check if user is admin
     */
    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user']) || !$_SESSION['user']['logged_in']) {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=user&action=login');
            exit();
        }
        
        // Check if user is admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=user&action=dashboard');
            exit();
        }
    }
    
    /**
     * Admin dashboard
     */
    public function dashboard() {
        $user = $this->getCurrentUser();
        
        // Get statistics
        $userModel = new UserModel();
        $eventModel = new EventModel();
        
        $data = [
            'user' => $user,
            'stats' => [
                'total_users' => count($userModel->getAllUsers()),
                'total_events' => count($eventModel->getAllEvents('admin', 'admin')),
                'upcoming_events' => 3,
                'total_revenue' => 1250.00
            ],
            'recent_users' => $userModel->getAllUsers(),
            'recent_events' => array_slice($eventModel->getAllEvents('admin', 'admin'), 0, 3)
        ];
        
        $this->view($data);
    }
    
    /**
     * User management
     */
    public function users() {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        
        $data = [
            'user' => $this->getCurrentUser(),
            'users' => $users
        ];
        
        $this->view($data);
    }
    
    /**
     * System settings
     */
    public function settings() {
        $data = [
            'user' => $this->getCurrentUser(),
            'settings' => [
                'site_name' => 'EventPro',
                'maintenance_mode' => false,
                'allow_registration' => true,
                'max_events_per_organizer' => 10
            ]
        ];
        
        $this->view($data);
    }
    
    /**
     * Edit user (placeholder)
     */
    public function editUser() {
        $username = $_GET['username'] ?? null;
        
        if (!$username) {
            $this->redirect('admin', 'users');
            return;
        }
        
        $data = [
            'user' => $this->getCurrentUser(),
            'edit_username' => $username
        ];
        
        $this->view($data);
    }
    
    /**
     * Delete user (placeholder)
     */
    public function deleteUser() {
        $username = $_GET['username'] ?? null;
        
        // In a real app, would delete from database
        
        header('Location: ' . PROJECT_URL . '/Index.php?controller=admin&action=users&deleted=1');
        exit();
    }
}
