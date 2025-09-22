<?php
// AdminController.php - Comprehensive admin console
class AdminController extends Controller
{
    private UserModel $userModel;
    private EventModel $eventModel;
    private VenueModel $venueModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->eventModel = new EventModel();
        $this->venueModel = new VenueModel();
    }
    
    // GET /admin/overview - Main admin dashboard
    public function overview(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/overview.php', [
            'title' => 'Overview - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/events - Event management
    public function events(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/events.php', [
            'title' => 'Events - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/analytics - Analytics dashboard
    public function analytics(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/analytics.php', [
            'title' => 'Analytics - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/users - User management
    public function users(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/users.php', [
            'title' => 'Users - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/database - Data console
    public function database(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/database.php', [
            'title' => 'Database - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/performance - Performance metrics
    public function performance(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/performance.php', [
            'title' => 'Performance - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/security - Security console
    public function security(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/security.php', [
            'title' => 'Security - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/reports - Reports
    public function reports(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/reports.php', [
            'title' => 'Reports - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/notifications - Notifications
    public function notifications(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/notifications.php', [
            'title' => 'Notifications - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /admin/settings - Settings
    public function settings(): void
    {
        $this->requireAdmin();
        
        $this->render('admin/settings.php', [
            'title' => 'Settings - EventHorizon Admin Console',
            'user' => $this->userOrNull(),
        ]);
    }
}
