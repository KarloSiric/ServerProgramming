<?php
// Admin endpoints with role-gated access - following your friend's clean pattern
class AdminController extends Controller
{
    // Main admin dashboard - auto-resolves to app/view/admin/overview.php
    public function overview() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Admin Dashboard - EventHorizon',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Event management page - auto-resolves to app/view/admin/events.php
    public function events() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Event Management - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Analytics dashboard - auto-resolves to app/view/admin/analytics.php  
    public function analytics() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Analytics - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // User management - auto-resolves to app/view/admin/users.php
    public function users() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'User Management - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Database console - auto-resolves to app/view/admin/database.php
    public function database() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Database Console - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Performance metrics - auto-resolves to app/view/admin/performance.php
    public function performance() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Performance - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Security console - auto-resolves to app/view/admin/security.php
    public function security() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Security - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Reports - auto-resolves to app/view/admin/reports.php
    public function reports() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Reports - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Notifications - auto-resolves to app/view/admin/notifications.php
    public function notifications() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Notifications - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Settings - auto-resolves to app/view/admin/settings.php
    public function settings() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Settings - EventHorizon Admin',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Process user management actions (activate, deactivate, delete)
    public function userAction($params = []) {
        $this->requireRole('admin');
        
        $action = $params[0] ?? '';
        $userId = $params[1] ?? '';
        
        if (empty($action) || empty($userId)) {
            $_SESSION['flash_error'] = 'Invalid user action.';
            $this->redirect('admin/users');
            return;
        }
        
        // In a real app, this would interact with the database
        switch ($action) {
            case 'activate':
                $_SESSION['flash_success'] = "User {$userId} activated successfully! (Demo mode)";
                break;
            case 'deactivate':
                $_SESSION['flash_success'] = "User {$userId} deactivated successfully! (Demo mode)";
                break;
            case 'delete':
                $_SESSION['flash_success'] = "User {$userId} deleted successfully! (Demo mode)";
                break;
            default:
                $_SESSION['flash_error'] = 'Unknown user action.';
        }
        
        $this->redirect('admin/users');
    }
    
    // Handle AJAX requests for dynamic admin interface updates
    public function ajax($params = []) {
        $this->requireRole('admin');
        
        $action = $params[0] ?? '';
        
        header('Content-Type: application/json');
        
        switch ($action) {
            case 'stats':
                // Return mock real-time statistics
                echo json_encode([
                    'events' => rand(15, 25),
                    'users' => rand(150, 300),
                    'registrations' => rand(45, 120),
                    'revenue' => '$' . number_format(rand(15000, 45000))
                ]);
                break;
                
            default:
                echo json_encode(['error' => 'Unknown AJAX action']);
        }
        exit;
    }
}
