<?php
/**
 * VenueController.php - Venue Management Controller
 * 
 * Manages venue-related operations in the system.
 * Currently provides read-only access to venue information.
 * 
 * Features:
 * - View list of all available venues
 * - Display venue details (name, capacity)
 * 
 * Future enhancements could include venue creation, editing, and deletion.
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class VenueController
 * 
 * Controller for displaying venue information.
 * Accessible to all authenticated users (both admin and regular users).
 */
class VenueController extends Controller
{
    /**
     * @var VenueModel $model Instance of VenueModel for database operations
     */
    private $model;

    /**
     * VenueController constructor
     * 
     * Initializes session management and model instance.
     * Checks for session expiration before allowing access.
     */
    public function __construct()
    {
        Session::start();
        
        // Check if session expired
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
        
        $this->model = new VenueModel();
    }

    /**
     * Display list of all venues
     * 
     * URL: /venue/index
     * 
     * Shows a read-only list of all venues in the system with:
     * - Venue ID
     * - Venue name
     * - Venue capacity
     * 
     * This information helps admins when creating/editing events,
     * as they need to select an appropriate venue with sufficient capacity.
     * 
     * Redirects to login if user is not authenticated.
     * 
     * @return void
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $venues = $this->model->all();
        $data = [
            'user' => $_SESSION['user'],
            'venues' => $venues
        ];
        $this->view($data);
    }
}
