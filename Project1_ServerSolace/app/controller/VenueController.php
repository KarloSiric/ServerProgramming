<?php
/**
 * @file VenueController.php
 * @brief Controller for venue management functionality
 * 
 * Handles venue viewing, creation, and management.
 * Venues are locations where events are held.
 * 
 * @author KarloSiric
 * @version 1.0
 */

/**
 * @class VenueController
 * @brief Manages venue-related operations
 * 
 * URL mappings:
 * - /venue/list → List all venues
 * - /venue/create → Create venue form
 * - /venue/store → Process venue creation
 * - /venue/edit&id=X → Edit venue form
 * - /venue/update → Process venue update
 * - /venue/delete&id=X → Delete venue
 */
class VenueController extends Controller {
  
  /**
   * @brief Display list of all venues
   * 
   * @return void
   * 
   * @details Shows all available venues with:
   * - Venue name
   * - Capacity
   * - Address
   * - Number of events hosted
   * 
   * @note URL: /venue/list
   * @note Accessible by: All users
   * @see app/view/venue/list.php
   */
  public function list() { 
    $this->view(); 
  }
  
  /**
   * @brief Display venue creation form
   * 
   * @return void
   * 
   * @details Admin form for adding new venues:
   * - Venue name input
   * - Capacity input
   * - Address fields
   * - Amenities checklist
   * 
   * @note URL: /venue/create
   * @note Restricted to: Admin users
   * @see app/view/venue/create.php
   */
  public function create() { 
    $this->requireRole('admin');
    $this->view(); 
  }
  
  /**
   * @brief Process venue creation (demo only)
   * 
   * @return void
   * 
   * @details Would save new venue to database:
   * 1. Validate input data
   * 2. Check for duplicate venues
   * 3. Save to database
   * 4. Redirect with success message
   * 
   * @note POST endpoint from create form
   * @warning Demo only - doesn't actually save
   * @todo Implement database storage
   */
  public function store() {
    $this->requireRole('admin');
    if (function_exists('flash')) {
      flash('success', 'Venue created successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?venue/list');
    exit;
  }
  
  /**
   * @brief Display venue edit form
   * 
   * @return void
   * 
   * @param int $_GET['id'] Venue ID to edit
   * 
   * @note URL: /venue/edit&id=1
   * @note Restricted to: Admin users
   * @todo Implement edit functionality
   */
  public function edit() {
    $this->requireRole('admin');
    $m = $this->model();
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $venues = $m->venues();
    $venue = null;
    
    foreach ($venues as $v) {
      if ($v['venue_id'] == $id) {
        $venue = $v;
        break;
      }
    }
    
    $this->view(['venue' => $venue]);
  }
  
  /**
   * @brief Process venue update (demo only)
   * 
   * @return void
   * 
   * @note POST endpoint from edit form
   * @warning Demo only - doesn't actually update
   */
  public function update() {
    $this->requireRole('admin');
    if (function_exists('flash')) {
      flash('success', 'Venue updated successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?venue/list');
    exit;
  }
  
  /**
   * @brief Delete a venue (demo only)
   * 
   * @return void
   * 
   * @param int $_GET['id'] Venue ID to delete
   * 
   * @note URL: /venue/delete&id=1
   * @note Restricted to: Admin users
   * @warning Demo only - doesn't actually delete
   * @todo Check if venue has events before deleting
   */
  public function delete() {
    $this->requireRole('admin');
    if (function_exists('flash')) {
      flash('warning', 'Venue deleted successfully!');
    }
    header('Location: ' . PROJECT_URL . '/Index.php?venue/list');
    exit;
  }
}
