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
            $_SESSION['flash_error'] = 'Event not found. ID was: ' . $id;
            $this->redirect('user/dashboard');
            return;
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
            return;
        }
        
        // In a real app, this would add to registrations table
        $_SESSION['flash_success'] = 'Successfully registered for ' . htmlspecialchars($event['name']) . '!';
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
                return;
            }
        }
        
        $this->view([
            'title' => 'Edit Event - EventHorizon Admin',
            'event' => $event,
            'user' => $this->userOrNull()
        ]);
    }
    
    // Admin: UNIFIED method to handle both event creation and editing
    public function store() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/events');
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = $_POST['date'] ?? '';
        $venue_id = (int)($_POST['venue_id'] ?? 0);
        $id = (int)($_POST['id'] ?? 0); // For editing existing events
        
        // Basic validation
        if (empty($name) || empty($description) || empty($date) || $venue_id === 0) {
            $_SESSION['flash_error'] = 'All fields are required.';
            
            if ($id > 0) {
                $this->redirect('event/edit/' . $id);
            } else {
                $this->redirect('event/create');
            }
            return;
        }
        
        $model = $this->model();
        
        if ($id > 0) {
            // Editing existing event - simulate success for demo
            $_SESSION['flash_success'] = 'Event "' . htmlspecialchars($name) . '" updated successfully! (Demo mode)';
        } else {
            // Creating new event - use existing createEvent method
            $success = $model->createEvent($name, $description, $date, $venue_id, [
                'type' => $_POST['type'] ?? 'conference',
                'time' => $_POST['time'] ?? '9:00 AM',
                'end_time' => $_POST['end_time'] ?? '5:00 PM',
                'price' => (int)($_POST['price'] ?? 199),
                'organizer' => $_POST['organizer'] ?? 'Event Foundation'
            ]);
            
            if ($success) {
                $_SESSION['flash_success'] = 'Event "' . htmlspecialchars($name) . '" created successfully!';
            } else {
                $_SESSION['flash_error'] = 'Failed to create event. Please try again.';
            }
        }
        
        $this->redirect('admin/events');
    }
    
    // Admin: Delete event
    public function delete($params = []) {
        $this->requireRole('admin');
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        if ($id > 0) {
            // In a real app, this would call model->deleteEvent($id)
            $_SESSION['flash_success'] = 'Event deleted successfully! (Demo mode)';
        } else {
            $_SESSION['flash_error'] = 'Invalid event ID.';
        }
        
        $this->redirect('admin/events');
    }
    
    // Admin: Toggle event status (active/inactive)
    public function toggle($params = []) {
        $this->requireRole('admin');
        $id = (int)($params[0] ?? $_GET['id'] ?? 0);
        
        if ($id === 0) {
            $_SESSION['flash_error'] = 'Invalid event ID.';
            $this->redirect('admin/events');
            return;
        }
        
        // In a real app, this would call model->toggleEventStatus($id)
        $_SESSION['flash_success'] = 'Event status updated successfully! (Demo mode)';
        $this->redirect('admin/events');
    }
}
