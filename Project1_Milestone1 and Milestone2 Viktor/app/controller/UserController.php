<?php
// auth and user pages; real auth comes later, demo-only flows live in views
class UserController extends Controller {
  public function login()  { $this->view(); } // shows form; demo login handled in view
  public function logout() {
    // dead-simple logout for milestone; clears session and goes home
    $_SESSION = []; session_destroy();
    header('Location: ' . PROJECT_URL . '/Index.php'); exit;
  }
  public function register(){ $this->view(); }          // shows form; demo register in view
  public function myregistrations(){ $this->view(); }   // attendee’s list
}
