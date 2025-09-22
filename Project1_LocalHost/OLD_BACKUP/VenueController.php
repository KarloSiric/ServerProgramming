<?php

/**
 * Venue Controller for EventPro
 * Handles venue management functionality
 * 
 * @author Student Implementation
 */
class VenueController extends Controller {
    
    /**
     * Lists all venues
     */
    public function list() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Get venues from model
        $venueModel = $this->model();
        $venues = $venueModel->getAllVenues();
        
        $data = [
            'user' => $user,
            'venues' => $venues
        ];
        
        $this->view($data);
    }
    
    /**
     * Shows venue details
     */
    public function view() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $venueId = $_GET['id'] ?? null;
        if (!$venueId) {
            $this->redirect('venue', 'list');
            return;
        }
        
        $venueModel = $this->model();
        $venue = $venueModel->getVenueById($venueId);
        
        if (!$venue) {
            $this->redirect('venue', 'list');
            return;
        }
        
        $data = [
            'user' => $this->getCurrentUser(),
            'venue' => $venue
        ];
        
        $this->view($data, 'detail');
    }
    
    /**
     * Shows create venue form (admin/organizer only)
     */
    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only organizers and admins can create venues
        if ($user['role'] !== 'organizer' && $user['role'] !== 'admin') {
            $this->redirect('venue', 'list');
            return;
        }
        
        $data = ['user' => $user];
        $this->view($data);
    }
    
    /**
     * Handles venue creation
     */
    public function store() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only organizers and admins can create venues
        if ($user['role'] !== 'organizer' && $user['role'] !== 'admin') {
            $this->redirect('venue', 'list');
            return;
        }
        
        // Process form data
        $venueModel = $this->model();
        $success = $venueModel->createVenue($_POST);
        
        if ($success) {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=venue&action=list&success=1');
        } else {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=venue&action=create&error=1');
        }
        exit();
    }
    
    /**
     * Deletes a venue (admin only)
     */
    public function delete() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only admins can delete venues
        if ($user['role'] !== 'admin') {
            $this->redirect('venue', 'list');
            return;
        }
        
        $venueId = $_GET['id'] ?? null;
        if ($venueId) {
            $venueModel = $this->model();
            $venueModel->deleteVenue($venueId);
        }
        
        $this->redirect('venue', 'list');
    }
}
