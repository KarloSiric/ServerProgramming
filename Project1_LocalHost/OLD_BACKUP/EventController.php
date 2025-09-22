<?php

/**
 * Event Controller for EventPro
 * Handles event management functionality
 * 
 * @author Student Implementation
 */
class EventController extends Controller {
    
    /**
     * Lists all events
     */
    public function list() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Get events from model (hardcoded for now)
        $eventModel = $this->model();
        $events = $eventModel->getAllEvents($user['role'], $user['username']);
        
        $data = [
            'user' => $user,
            'events' => $events
        ];
        
        $this->view($data);
    }
    
    /**
     * Shows create event form
     */
    public function create() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only organizers can create events
        if ($user['role'] !== 'organizer' && $user['role'] !== 'admin') {
            $this->redirect('event', 'list');
            return;
        }
        
        $data = ['user' => $user];
        $this->view($data);
    }
    
    /**
     * Handles event creation
     */
    public function store() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only organizers can create events
        if ($user['role'] !== 'organizer' && $user['role'] !== 'admin') {
            $this->redirect('event', 'list');
            return;
        }
        
        // Process form data
        $eventModel = $this->model();
        $success = $eventModel->createEvent($_POST);
        
        if ($success) {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=event&action=list&success=1');
        } else {
            header('Location: ' . PROJECT_URL . '/Index.php?controller=event&action=create&error=1');
        }
        exit();
    }
    
    /**
     * Shows event details
     */
    public function view() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $eventId = $_GET['id'] ?? null;
        if (!$eventId) {
            $this->redirect('event', 'list');
            return;
        }
        
        $eventModel = $this->model();
        $event = $eventModel->getEventById($eventId);
        
        if (!$event) {
            $this->redirect('event', 'list');
            return;
        }
        
        $data = [
            'user' => $this->getCurrentUser(),
            'event' => $event
        ];
        
        $this->view($data, 'detail');
    }
    
    /**
     * Deletes an event
     */
    public function delete() {
        if (!$this->isLoggedIn()) {
            $this->redirect('user', 'login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Only organizers/admins can delete events
        if ($user['role'] !== 'organizer' && $user['role'] !== 'admin') {
            $this->redirect('event', 'list');
            return;
        }
        
        $eventId = $_GET['id'] ?? null;
        if ($eventId) {
            $eventModel = $this->model();
            $eventModel->deleteEvent($eventId);
        }
        
        $this->redirect('event', 'list');
    }
}
