<?php
/**
 * EventController.php - Event Management Controller
 * 
 * Handles all event-related operations for both administrators and regular users:
 * 
 * Admin Functions:
 * - View all events in management dashboard
 * - Create new events
 * - Edit existing events
 * - Delete events
 * - View attendee lists for events
 * 
 * User Functions:
 * - Browse available events
 * - Register for events
 * - Unregister from events
 * 
 * @author Karlo Siric
 * @version 1.0
 */

declare(strict_types=1);

/**
 * Class EventController
 * 
 * Controller that manages event CRUD operations and user registrations.
 * Provides different views and functionality based on user role (admin vs attendee).
 */
class EventController extends Controller
{
    /**
     * @var EventModel $model Instance of EventModel for event database operations
     */
    private $model;
    
    /**
     * @var UserModel $userModel Instance of UserModel for user-related operations
     */
    private $userModel;

    /**
     * EventController constructor
     * 
     * Initializes session management, checks for expiration,
     * and sets up model instances.
     */
    public function __construct()
    {
        Session::start();
        
        // Check if session expired
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
        
        $this->model = new EventModel();
        $this->userModel = new UserModel();
    }

    /* ---------- Event Viewing (For All Users) ---------- */

    /**
     * Display all events (different views for admin vs users)
     * 
     * URL: /event/all
     * 
     * For Admins:
     * - Shows management dashboard with full event details
     * - Includes edit/delete/view attendees actions
     * - Displays capacity and registration statistics
     * 
     * For Regular Users:
     * - Shows browsable event list
     * - Displays register/unregister buttons
     * - Shows registration status for each event
     * 
     * @return void
     */
    public function all(): void
    {
        // Require authentication
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        // Get all events from database
        $events = $this->model->getAllEvents();

        // ADMIN VIEW - Management dashboard
        if ($_SESSION['user']['role_name'] === 'admin') {
            $venues = $this->model->getVenues();

            $data = [
                'user' => $_SESSION['user'],
                'events' => $events,
                'venues' => $venues
            ];
            
            $viewTemplate = 'app/view/event/events.php';
            
            if (!file_exists($viewTemplate)) {
                throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
            }

            extract($data);
            require 'app/view/inc/header.php';
            require $viewTemplate;
            require 'app/view/inc/footer.php';
        } 
        // USER VIEW - Browse and register
        else {
            $userId = (int)$_SESSION['user']['id'];
            $registeredEventIds = $this->model->getUserRegisteredEvents($userId);

            $data = [
                'user' => $_SESSION['user'],
                'events' => $events,
                'registeredEventIds' => $registeredEventIds
            ];
            
            $viewTemplate = 'app/view/event/browse.php';
            
            if (!file_exists($viewTemplate)) {
                throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
            }

            extract($data);
            require 'app/view/inc/header.php';
            require $viewTemplate;
            require 'app/view/inc/footer.php';
        }
    }

    /**
     * Alias for all() method
     * 
     * Provides backward compatibility for /event/index URLs
     * 
     * @return void
     */
    public function index(): void
    {
        $this->all();
    }

    /**
     * Alias for all() method
     * 
     * Provides backward compatibility for /event/browse URLs
     * 
     * @return void
     */
    public function browse(): void
    {
        $this->all();
    }

    /* ---------- User Registration Functions ---------- */

    /**
     * Register current user for an event
     * 
     * URL: /event/register (POST only)
     * 
     * Adds the authenticated user to the specified event's attendee list.
     * Checks for:
     * - Duplicate registrations (user already registered)
     * - Event capacity (event not full)
     * 
     * Redirects back to event list after registration.
     * 
     * @return void (exits via redirect)
     */
    public function register(): void
    {
        if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $eventId = (int)($_POST['event_id'] ?? 0);
        $userId = (int)$_SESSION['user']['id'];

        if ($eventId > 0) {
            $this->model->registerUserForEvent($userId, $eventId);
        }

        header('Location: ' . PROJECT_URL . '/event/all');
        exit;
    }

    /**
     * Unregister current user from an event
     * 
     * URL: /event/unregister (POST only)
     * 
     * Removes the authenticated user from the specified event's attendee list.
     * Redirects back to event list after unregistration.
     * 
     * @return void (exits via redirect)
     */
    public function unregister(): void
    {
        if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $eventId = (int)($_POST['event_id'] ?? 0);
        $userId = (int)$_SESSION['user']['id'];

        if ($eventId > 0) {
            $this->model->unregisterUserFromEvent($userId, $eventId);
        }

        header('Location: ' . PROJECT_URL . '/event/all');
        exit;
    }

    /* ---------- Admin-Only Functions ---------- */

    /**
     * View attendees for a specific event (Admin only)
     * 
     * URL: /event/attendees/{eventId}
     * Example: /event/attendees/5
     * 
     * Displays a list of all users registered for the specified event.
     * Shows attendee details: name, username, email, payment status.
     * 
     * @param array $params URL parameters, where $params[0] is the event ID
     * @return void
     */
    public function attendees($params = []): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        if ($_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/attendee/dashboard');
            exit;
        }

        $eventId = (int)($params[0] ?? 0);

        if ($eventId <= 0) {
            die("Invalid event ID");
        }

        $event = $this->model->find($eventId);
        if (!$event) {
            die("Event not found");
        }

        $attendees = $this->userModel->getAttendees($eventId);

        $data = [
            'user' => $_SESSION['user'],
            'event' => $event,
            'eventId' => $eventId,
            'attendees' => $attendees
        ];

        $viewTemplate = 'app/view/event/attendees.php';
        
        if (!file_exists($viewTemplate)) {
            throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
        }

        extract($data);
        require 'app/view/inc/header.php';
        require $viewTemplate;
        require 'app/view/inc/footer.php';
    }

    /**
     * Display create event form (Admin only)
     * 
     * URL: /event/create (GET)
     * 
     * Shows a form for creating a new event with fields for:
     * - Event name
     * - Start date/time
     * - End date/time
     * - Capacity (allowed number of attendees)
     * - Venue selection
     * 
     * @return void
     */
    public function create(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $venues = $this->model->getVenues();

        $data = [
            'user' => $_SESSION['user'],
            'venues' => $venues,
            'event' => null  // Null indicates this is a create operation
        ];

        $viewTemplate = 'app/view/event/event-form.php';
        
        if (!file_exists($viewTemplate)) {
            throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
        }

        extract($data);
        require 'app/view/inc/header.php';
        require $viewTemplate;
        require 'app/view/inc/footer.php';
    }

    /**
     * Process create event form submission (Admin only)
     * 
     * URL: /event/store (POST)
     * 
     * Validates and inserts a new event into the database.
     * Generates a unique event_id automatically.
     * Redirects to event list on success.
     * 
     * @return void (exits via redirect)
     */
    public function store(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'start_date' => trim($_POST['start_date'] ?? ''),
                'end_date' => trim($_POST['end_date'] ?? ''),
                'allowed_number' => (int)($_POST['allowed_number'] ?? 0),
                'venue_id' => (int)($_POST['venue_id'] ?? 0)
            ];

            $this->model->create($data);
            header('Location: ' . PROJECT_URL . '/event/all');
            exit;
        }
    }

    /**
     * Display edit event form (Admin only)
     * 
     * URL: /event/edit/{eventId}
     * Example: /event/edit/5
     * 
     * Shows a pre-filled form for editing an existing event.
     * Uses the same form template as create, but with event data populated.
     * 
     * @param array $params URL parameters, where $params[0] is the event ID
     * @return void
     */
    public function edit($params = []): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $eventId = (int)($params[0] ?? 0);

        if ($eventId <= 0) {
            die("Invalid event ID");
        }

        $event = $this->model->find($eventId);
        if (!$event) {
            die("Event not found");
        }

        $venues = $this->model->getVenues();

        $data = [
            'user' => $_SESSION['user'],
            'event' => $event,  // Event data for pre-filling form
            'venues' => $venues
        ];

        $viewTemplate = 'app/view/event/event-form.php';
        
        if (!file_exists($viewTemplate)) {
            throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
        }

        extract($data);
        require 'app/view/inc/header.php';
        require $viewTemplate;
        require 'app/view/inc/footer.php';
    }

    /**
     * Process edit event form submission (Admin only)
     * 
     * URL: /event/update (POST)
     * 
     * Validates and updates an existing event in the database.
     * Redirects to event list on success.
     * 
     * @return void (exits via redirect)
     */
    public function update(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'start_date' => trim($_POST['start_date'] ?? ''),
                'end_date' => trim($_POST['end_date'] ?? ''),
                'allowed_number' => (int)($_POST['allowed_number'] ?? 0),
                'venue_id' => (int)($_POST['venue_id'] ?? 0)
            ];

            $this->model->update($id, $data);
            header('Location: ' . PROJECT_URL . '/event/all');
            exit;
        }
    }

    /**
     * Delete an event (Admin only)
     * 
     * URL: /event/destroy (POST)
     * 
     * Permanently deletes an event and all associated registrations.
     * Uses database transaction to ensure data integrity.
     * Redirects to event list on success.
     * 
     * @return void (exits via redirect)
     */
    public function destroy(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id > 0) {
                $this->model->delete($id);
            }
            
            header('Location: ' . PROJECT_URL . '/event/all');
            exit;
        }
    }
}
