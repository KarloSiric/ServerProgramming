<?php
/**
 * @file SiteController.php
 * @brief Controller for public site pages
 * 
 * Handles publicly accessible pages that don't require authentication.
 * This is the default controller when no route is specified.
 * 
 * @author KarloSiric
 * @version 1.0
 */

/**
 * @class SiteController
 * @brief Handles public website pages
 * 
 * URL mappings:
 * - / (empty) → Home page (default)
 * - /site/home → Home page
 * - /site/about → About page (future)
 * - /site/contact → Contact page (future)
 * - /site/terms → Terms of service (future)
 * - /site/privacy → Privacy policy (future)
 */
class SiteController extends Controller {
  
  /**
   * @brief Display home/landing page
   * 
   * @return void
   * 
   * @details The main landing page showing:
   * - Welcome message
   * - Login/Register buttons (for guests)
   * - Dashboard link (for logged-in users)
   * - Application branding
   * 
   * @note This is the DEFAULT action when no route specified
   * @note Public access - no authentication required
   * @see app/view/site/home.php
   * @see Router::__construct() Sets this as default
   */
  public function home() { 
    $this->view(); 
  }
  
  /**
   * @brief Display about page
   * 
   * @return void
   * 
   * @details Information about EventHorizon:
   * - Company mission
   * - Team information
   * - Features overview
   * 
   * @note Public access
   * @todo Implement about page view
   */
  public function about() { 
    $this->view(); 
  }
  
  /**
   * @brief Display contact page
   * 
   * @return void
   * 
   * @details Contact information and form:
   * - Contact form
   * - Office locations
   * - Support information
   * 
   * @note Public access
   * @todo Implement contact page view
   * @todo Add contact form processing
   */
  public function contact() { 
    $this->view(); 
  }
  
  /**
   * @brief Display terms of service
   * 
   * @return void
   * 
   * @details Legal terms and conditions
   * 
   * @note Public access
   * @todo Implement terms page
   */
  public function terms() { 
    $this->view(); 
  }
  
  /**
   * @brief Display privacy policy
   * 
   * @return void
   * 
   * @details Privacy and data handling policy
   * 
   * @note Public access
   * @todo Implement privacy page
   */
  public function privacy() { 
    $this->view(); 
  }
}
