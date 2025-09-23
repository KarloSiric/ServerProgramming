<?php
// EventController.php - EventHorizon event management
class EventController extends Controller
{
    private EventModel $eventModel;
    
    public function __construct()
    {
        $this->eventModel = new EventModel();
    }
    
    // GET /event/list - List all events
    public function list(): void
    {
        $this->requireLogin();
        $events = $this->eventModel->getAllEvents();
        
        $this->render('event/list.php', [
            'title' => 'Events - EventHorizon',
            'events' => $events,
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /event/view - View single event
    public function view(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $event = $this->eventModel->getEventById($id);
        
        if (!$event) {
            $_SESSION['flash_error'] = 'Event not found.';
            $this->redirect('/user/dashboard');
        }
        
        $this->render('event/view.php', [
            'title' => htmlspecialchars($event['name']) . ' - EventHorizon',
            'event' => $event,
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /event/register - Register for event
    public function register(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $event = $this->eventModel->getEventById($id);
        
        if (!$event) {
            $_SESSION['flash_error'] = 'Event not found.';
            $this->redirect('/user/dashboard');
        }
        
        // In a real app, this would add to registrations table
        $_SESSION['flash_success'] = 'Successfully registered for ' . $event['name'] . '!';
        $this->redirect('/user/dashboard');
    }
    
    // Admin functions
    public function create(): void
    {
        $this->requireAdmin();
        
        $this->render('event/create.php', [
            'title' => 'Create Event - EventHorizon Admin',
            'user' => $this->userOrNull(),
            'error' => $_SESSION['flash_error'] ?? null,
        ]);
        unset($_SESSION['flash_error']);
    }
    
    public function store(): void
    {
        $this->requireAdmin();
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = $_POST['date'] ?? '';
        $venue_id = (int)($_POST['venue_id'] ?? 0);
        
        if (empty($name) || empty($description) || empty($date) || $venue_id === 0) {
            $_SESSION['flash_error'] = 'All fields are required.';
            $this->redirect('/event/create');
        }
        
        $success = $this->eventModel->createEvent($name, $description, $date, $venue_id);
        if ($success) {
            $_SESSION['flash_success'] = 'Event created successfully!';
            $this->redirect('/user/dashboard');
        } else {
            $_SESSION['flash_error'] = 'Failed to create event.';
            $this->redirect('/event/create');
        }
    }
}
