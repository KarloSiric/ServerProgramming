<?php
/**
 * @file AdminController.php
 * @brief Controller for administrative functionality
 * 
 * Provides admin-only views and management interfaces.
 * All methods are protected by role-based access control.
 * 
 * @author KarloSiric
 * @version 1.0
 * 
 * @note Every action requires admin role
 */

/**
 * @class AdminController
 * @brief Handles all admin panel functionality
 * 
 * URL mappings (all require admin role):
 * - /admin/overview → Dashboard overview
 * - /admin/events → Event management
 * - /admin/users → User management
 * - /admin/analytics → System analytics
 * - /admin/reports → Generate reports
 * - /admin/settings → System settings
 * - /admin/security → Security dashboard
 * - /admin/database → Database management
 * - /admin/performance → Performance metrics
 * - /admin/notifications → System notifications
 * 
 * @warning All methods check for admin role before rendering
 */
class AdminController extends Controller {
  
  /**
   * @brief Admin dashboard overview
   * 
   * @return void
   * 
   * @details Shows comprehensive admin dashboard with:
   * - System statistics
   * - Recent activity
   * - Quick actions
   * - Performance metrics
   * 
   * @note URL: /admin/overview
   * @note Required role: admin
   * @see app/view/admin/overview.php
   */
  public function overview() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Event management interface
   * 
   * @return void
   * 
   * @details Provides CRUD operations for events:
   * - List all events with details
   * - Edit/Delete buttons
   * - Create new event link
   * - Event statistics
   * 
   * @note URL: /admin/events
   * @note Required role: admin
   * @see app/view/admin/events.php
   */
  public function events() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief User management interface
   * 
   * @return void
   * 
   * @details Manage system users:
   * - List all users
   * - View user details
   * - Edit user roles
   * - User statistics
   * 
   * @note URL: /admin/users
   * @note Required role: admin
   * @see app/view/admin/users.php
   */
  public function users() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Analytics dashboard
   * 
   * @return void
   * 
   * @details System analytics including:
   * - Event attendance trends
   * - User registration stats
   * - Revenue analytics
   * - Engagement metrics
   * 
   * @note URL: /admin/analytics
   * @note Required role: admin
   * @see app/view/admin/analytics.php
   */
  public function analytics() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Reports generation interface
   * 
   * @return void
   * 
   * @details Generate various reports:
   * - Event reports
   * - Financial reports
   * - User activity reports
   * - Custom date ranges
   * 
   * @note URL: /admin/reports
   * @note Required role: admin
   * @see app/view/admin/reports.php
   */
  public function reports() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief System settings interface
   * 
   * @return void
   * 
   * @details Configure system settings:
   * - General settings
   * - Email configuration
   * - Payment settings
   * - Site preferences
   * 
   * @note URL: /admin/settings
   * @note Required role: admin
   * @see app/view/admin/settings.php
   */
  public function settings() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Security dashboard
   * 
   * @return void
   * 
   * @details Security monitoring:
   * - Login attempts
   * - Security alerts
   * - User sessions
   * - System logs
   * 
   * @note URL: /admin/security
   * @note Required role: admin
   * @see app/view/admin/security.php
   */
  public function security() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Database management interface
   * 
   * @return void
   * 
   * @details Database operations:
   * - Connection status
   * - Backup management
   * - Query statistics
   * - Optimization tools
   * 
   * @note URL: /admin/database
   * @note Required role: admin
   * @see app/view/admin/database.php
   * @warning Handle with care - production database access
   */
  public function database() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Performance monitoring dashboard
   * 
   * @return void
   * 
   * @details System performance metrics:
   * - Response times
   * - Server load
   * - Cache statistics
   * - Resource usage
   * 
   * @note URL: /admin/performance
   * @note Required role: admin
   * @see app/view/admin/performance.php
   */
  public function performance() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
  
  /**
   * @brief Notification management
   * 
   * @return void
   * 
   * @details Manage system notifications:
   * - Email notifications
   * - System alerts
   * - User messages
   * - Broadcast messages
   * 
   * @note URL: /admin/notifications
   * @note Required role: admin
   * @see app/view/admin/notifications.php
   */
  public function notifications() { 
    $this->requireRole('admin'); 
    $this->view(); 
  }
}
