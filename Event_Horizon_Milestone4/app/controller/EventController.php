<?php

declare(strict_types=1);

class EventController extends Controller
{
    private $model;
    private $userModel;

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

    // FOR BOTH ADMIN AND USERS - View all events
    public function all(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

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

    // Aliases for backward compatibility
    public function index(): void
    {
        $this->all();
    }

    public function browse(): void
    {
        $this->all();
    }

    // Register attendee for an event
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

    // Unregister attendee from an event
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
            'event' => null
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
            'event' => $event,
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
