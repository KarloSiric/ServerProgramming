<?php
// Event endpoints - clean controller actions that auto-resolve views
class EventController extends Controller
{
    // Event list page - auto-resolves to app/view/event/list.php
    public function list() { 
        $this->requireLogin(); 
        $this->view([
            'title' => 'Events - EventHorizon',
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Event detail view - auto-resolves to app/view/event/view.php
    public function view($params = []) { 
        $this->requireLogin(); 
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        $model = $this->model();
        $event = $model->getEventById($id);
        
        if (!$event) {
            $_SESSION['flash_error'] = 'Event not found.';
            $this->redirect('user/dashboard');
        }
        
        $this->view([
            'title' => htmlspecialchars($event['name']) . ' - EventHorizon',
            'event' => $event,
            'user' => $this->userOrNull()
        ]); 
    }
    
    // Event registration - handles registration and redirects
    public function register($params = []) { 
        $this->requireLogin(); 
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        $model = $this->model();
        $event = $model->getEventById($id);
        
        if (!$event) {
            $_SESSION['flash_error'] = 'Event not found.';
            $this->redirect('user/dashboard');
        }
        
        // In a real app, this would add to registrations table
        $_SESSION['flash_success'] = 'Successfully registered for ' . $event['name'] . '!';
        $this->redirect('user/dashboard');
    }
    
    // Admin: Create event form - auto-resolves to app/view/event/create.php
    public function create() { 
        $this->requireRole('admin'); 
        $this->view([
            'title' => 'Create Event - EventHorizon Admin',
            'user' => $this->userOrNull(),
            'error' => $_SESSION['flash_error'] ?? null
        ]); 
        unset($_SESSION['flash_error']);
    }
    
    // Admin: Edit event form - auto-resolves to app/view/event/create.php (reused)
    public function edit($params = []) {
        $this->requireRole('admin');
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        $model = $this->model();
        $event = null;
        
        if ($id) {
            $event = $model->getEventById($id);
            if (!$event) {
                $_SESSION['flash_error'] = 'Event not found.';
                $this->redirect('admin/events');
            }
        }
        
        $this->view([
            'title' => 'Edit Event - EventHorizon Admin',
            'event' => $event,
            'user' => $this->userOrNull()
        ]);
    }
    
    // Admin: Process event creation/editing
    public function store() {
        $this->requireRole('admin');
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = $_POST['date'] ?? '';
        $venue_id = (int)($_POST['venue_id'] ?? 0);
        
        if (empty($name) || empty($description) || empty($date) || $venue_id === 0) {
            $_SESSION['flash_error'] = 'All fields are required.';
            $this->redirect('event/create');
        }
        
        $model = $this->model();
        $success = $model->createEvent($name, $description, $date, $venue_id);
        
        if ($success) {
            $_SESSION['flash_success'] = 'Event created successfully!';
            $this->redirect('admin/events');
        } else {
            $_SESSION['flash_error'] = 'Failed to create event.';
            $this->redirect('event/create');
        }
    }
    
    // Admin: Delete event (demo mode)
    public function delete($params = []) {
        $this->requireRole('admin');
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        if ($id) {
            // In a real app, this would call model->deleteEvent($id)
            $_SESSION['flash_success'] = 'Event deleted successfully (demo mode)!';
        } else {
            $_SESSION['flash_error'] = 'Invalid event ID.';
        }
        
        $this->redirect('admin/events');
    }
}
