<?php
// VenueController.php - Enhanced venue management
class VenueController extends Controller
{
    private VenueModel $venueModel;
    
    public function __construct()
    {
        $this->venueModel = new VenueModel();
    }
    
    // GET /venue/list - List all venues
    public function list(): void
    {
        $this->requireLogin();
        $venues = $this->venueModel->getAllVenues();
        
        $this->render('venue/list.php', [
            'title' => 'Event Venues - TechEvents Pro',
            'venues' => $venues,
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /venue/create - Show create form (admin only)
    public function create(): void
    {
        $this->requireAdmin();
        
        $this->render('venue/create.php', [
            'title' => 'Add Venue - TechEvents Pro',
            'user' => $this->userOrNull(),
            'error' => $_SESSION['flash_error'] ?? null,
            'success' => $_SESSION['flash_success'] ?? null,
        ]);
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);
    }
    
    // POST /venue/store - Store new venue
    public function store(): void
    {
        $this->requireAdmin();
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $capacity = (int)($_POST['capacity'] ?? 0);
        $location = trim($_POST['location'] ?? '');
        $type = $_POST['type'] ?? 'Event Space';
        $hourly_rate = (int)($_POST['hourly_rate'] ?? 100);
        $contact_phone = trim($_POST['contact_phone'] ?? '');
        $contact_email = trim($_POST['contact_email'] ?? '');
        
        if (empty($name) || $capacity <= 0 || empty($location)) {
            $_SESSION['flash_error'] = 'Name, capacity, and location are required.';
            $this->redirect('/venue/create');
        }
        
        if ($capacity > 10000) {
            $_SESSION['flash_error'] = 'Capacity cannot exceed 10,000 people.';
            $this->redirect('/venue/create');
        }
        
        // Process amenities
        $amenities = $_POST['amenities'] ?? [];
        $customAmenities = trim($_POST['custom_amenities'] ?? '');
        
        if (!empty($customAmenities)) {
            $customArray = array_map('trim', explode(',', $customAmenities));
            $amenities = array_merge($amenities, $customArray);
        }
        
        // Validate email if provided
        if (!empty($contact_email) && !filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Please provide a valid email address.';
            $this->redirect('/venue/create');
        }
        
        $extraData = [
            'description' => $description,
            'amenities' => $amenities,
            'type' => $type,
            'hourly_rate' => $hourly_rate,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
        ];
        
        $success = $this->venueModel->createVenue($name, $capacity, $location, $extraData);
        if ($success) {
            $_SESSION['flash_success'] = 'Venue added successfully!';
            $this->redirect('/venue/list');
        } else {
            $_SESSION['flash_error'] = 'Failed to add venue. Please try again.';
            $this->redirect('/venue/create');
        }
    }
    
    // GET /venue/view - View single venue
    public function view(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $venue = $this->venueModel->getVenueById($id);
        
        if (!$venue) {
            $_SESSION['flash_error'] = 'Venue not found.';
            $this->redirect('/venue/list');
        }
        
        $this->render('venue/view.php', [
            'title' => htmlspecialchars($venue['name']) . ' - TechEvents Pro',
            'venue' => $venue,
            'user' => $this->userOrNull(),
        ]);
    }
    
    // GET /venue/book - Show booking form for venue
    public function book(): void
    {
        $this->requireLogin();
        $user = $this->userOrNull();
        
        if (($user['role'] ?? '') === 'admin') {
            $_SESSION['flash_error'] = 'Use the create event form to schedule venue usage.';
            $this->redirect('/venue/list');
        }
        
        $id = (int)($_GET['id'] ?? 0);
        $venue = $this->venueModel->getVenueById($id);
        
        if (!$venue) {
            $_SESSION['flash_error'] = 'Venue not found.';
            $this->redirect('/venue/list');
        }
        
        // In a real app, this would show a booking form
        $_SESSION['flash_success'] = 'Booking inquiry sent for ' . $venue['name'] . '!';
        $this->redirect('/venue/view?id=' . $id);
    }
    
    // GET /venue/filter - Filter venues by type/capacity
    public function filter(): void
    {
        $this->requireLogin();
        $type = $_GET['type'] ?? '';
        $capacity_range = $_GET['capacity'] ?? '';
        
        if ($type) {
            $venues = $this->venueModel->getVenuesByType($type);
        } else {
            $venues = $this->venueModel->getAllVenues();
        }
        
        // Filter by capacity range if specified
        if ($capacity_range) {
            $venues = array_filter($venues, function($venue) use ($capacity_range) {
                switch ($capacity_range) {
                    case 'small':
                        return $venue['capacity'] <= 50;
                    case 'medium':
                        return $venue['capacity'] > 50 && $venue['capacity'] <= 200;
                    case 'large':
                        return $venue['capacity'] > 200;
                    default:
                        return true;
                }
            });
        }
        
        $this->render('venue/list.php', [
            'title' => 'Filtered Venues - TechEvents Pro',
            'venues' => array_values($venues),
            'user' => $this->userOrNull(),
            'current_filter' => $type,
            'current_capacity' => $capacity_range,
        ]);
    }
}
