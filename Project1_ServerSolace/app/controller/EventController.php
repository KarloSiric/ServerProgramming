<?php
/**
 * @file EventController.php
 * @brief Controller handling all event-related functionality
 * 
 * Manages event viewing, creation, editing, deletion, and registration.
 * This is the primary controller for the application's core functionality.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @see Controller Base controller class
 * @see AppModel For event data
 */

/**
 * @class EventController
 * @brief Handles all event-related actions
 * 
 * URL mappings:
 * - /event/index → List all events
 * - /event/show&id=X → Show event details
 * - /event/create → Show create form
 * - /event/store → Process create form
 * - /event/edit&id=X → Show edit form
 * - /event/update → Process edit form
 * - /event/delete&id=X → Delete event
 * - /event/register&id=X → Register for event
 */
class EventController extends Controller {
  
  /**
   * @brief Display list of all events
   * 
   * @return void
   * 
   * @details Renders event/index.php view
   * View receives $events array from header.php
   * 
   * @note Accessible by: All users (public)
   * @see app/view/event/index.php
   */
  public function index() { 
    $this->view(); 
  }
  
  /**
   * @brief Display single event details
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Get event ID from $_GET['id']
   * 2. Load events from model
   * 3. Find matching event by ID
   * 4. Enrich with venue details
   * 5. Pass to view as $event
   * 
   * @note URL: /event/show&id=1
   * @note Also accessible via /event/view (aliased in Router)
   * 
   * @see app/view/event/show.php
   * @see Router::dispatch() For URL aliasing
   */
  public function show() { 
    // Get event ID from query string (default to 1)
    $m = $this->model();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $events = $m->events();
    $venues = $m->venues();
    $event = null;
    
    // Find event by ID
    foreach ($events as $e) {
      if ($e['event_id'] == $id) {
        $event = $e;
        
        // Enrich with venue details
        foreach ($venues as $v) {
          if ($v['venue_id'] == $e['venue_id']) {
            $event['venue_name'] = $v['name'];
            $event['venue_capacity'] = $v['capacity'];
            $event['venue_address'] = $v['address'];
            break;
          }
        }
        break;
      }
    }
    
    // Pass event data to view
    parent::view(['event' => $event]); 
  }
  
  /**
   * @brief Display event creation form
   * 
   * @return void
   * 
   * @details Admin only - shows form for creating new events
   * View receives $venues array for dropdown
   * 
   * @note URL: /event/create
   * @note Restricted to: Admin users
   * @see app/view/event/create.php
   */
  public function create() { 
    $this->view(); 
  }
  
  /**
   * @brief Display event edit form
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Get event ID from $_GET['id']
   * 2. Load event data
   * 3. Pass to edit form for pre-population
   * 
   * @note URL: /event/edit&id=1
   * @note Restricted to: Admin users
   * @see app/view/event/edit.php
   */
  public function edit() {
    // Load event data for editing
    $m = $this->model();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $events = $m->events();
    $event = null;
    
    // Find event to edit
    foreach ($events as $e) {
      if ($e['event_id'] == $id) {
        $event = $e;
        break;
      }
    }
    
    // Pass to edit view
    parent::view(['event' => $event]);
  }
  
  /**
   * @brief Delete an event (demo only)
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Get event ID from $_GET['id']
   * 2. In production: Would delete from database
   * 3. Currently: Just shows success message
   * 4. Redirects to admin events list
   * 
   * @note URL: /event/delete&id=1
   * @note Restricted to: Admin users
   * @warning Demo only - doesn't actually delete
   */
  public function delete() {
    // Demo delete - just redirect back
    if (function_exists('flash')) {
      flash('success', 'Event deleted successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?admin/events');
    exit;
  }
  
  /**
   * @brief Process event creation form (demo only)
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Receive POST data from create form
   * 2. In production: Would validate and save to database
   * 3. Currently: Just shows success message
   * 4. Redirects to admin events list
   * 
   * @note URL: /event/store (POST only)
   * @note Called by: event/create.php form submission
   * @warning Demo only - doesn't actually save
   */
  public function store() {
    // Demo store - just redirect back
    if (function_exists('flash')) {
      flash('success', 'Event created successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?admin/events');
    exit;
  }
  
  /**
   * @brief Process event update form (demo only)
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Receive POST data from edit form
   * 2. In production: Would validate and update database
   * 3. Currently: Just shows success message
   * 4. Redirects to admin events list
   * 
   * @note URL: /event/update (POST only)
   * @note Called by: event/edit.php form submission
   * @warning Demo only - doesn't actually update
   */
  public function update() {
    // Demo update - just redirect back
    if (function_exists('flash')) {
      flash('success', 'Event updated successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?admin/events');
    exit;
  }
  
  /**
   * @brief Register user for an event (demo only)
   * 
   * @return void
   * 
   * @details Processing:
   * 1. Get event ID from $_GET['id']
   * 2. In production: Would create registration record
   * 3. Currently: Just shows success message
   * 4. Redirects to user dashboard
   * 
   * @note URL: /event/register&id=1
   * @note Restricted to: Logged-in users
   * @warning Demo only - doesn't actually register
   * 
   * @todo Implement actual registration logic
   * @todo Check event capacity
   * @todo Send confirmation email
   */
  public function register() {
    // Demo registration
    if (function_exists('flash')) {
      flash('success', 'Successfully registered for event!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?user/dashboard');
    exit;
  }
}
