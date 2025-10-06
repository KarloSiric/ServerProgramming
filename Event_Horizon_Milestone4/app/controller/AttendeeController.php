<?php
/**
 * AttendeeController.php - Attendee Dashboard Controller
 * 
 * Manages the attendee user dashboard, providing a personalized
 * portal for regular (non-admin) users.
 * 
 * Features:
 * - Displays user-specific welcome message
 * - Provides quick access to event browsing
 * - Shows user account status and membership information
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class AttendeeController
 * 
 * Controller for attendee-specific pages and functionality.
 * Accessible only to authenticated non-admin users.
 */
class AttendeeController extends Controller
{
    /**
     * AttendeeController constructor
     * 
     * Initializes session and checks for expiration.
     * Ensures user is authenticated before accessing attendee pages.
     */
    public function __construct()
    {
        Session::start();
        
        // Check if session expired
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
    }

    /**
     * Display attendee dashboard
     * 
     * URL: /attendee/dashboard
     * 
     * Shows a personalized welcome page for regular users with:
     * - Welcome message with username
     * - Account status badges (Active Status, Member Since)
     * - Quick action cards (Browse Events, Sign Out)
     * - Helpful tips for using the system
     * 
     * Redirects to login if user is not authenticated.
     * 
     * @return void
     */
    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $data = ['user' => $_SESSION['user']];
        $this->view($data);
    }
}
