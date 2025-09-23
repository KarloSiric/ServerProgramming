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
}
