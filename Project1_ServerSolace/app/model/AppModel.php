<?php
/**
 * @file AppModel.php
 * @brief Demo data provider for EventHorizon application
 * 
 * Provides hardcoded demo data as a stand-in for database.
 * This is a temporary solution for Milestone 1/2 before database implementation.
 * All data is stored in memory as PHP arrays.
 * 
 * @author KarloSiric
 * @version 1.0
 * @date 2024
 * 
 * @details Data Structure:
 * - Simulates relational database tables
 * - Uses array keys to simulate primary/foreign keys
 * - Data is denormalized for convenience (includes joined data)
 * 
 * @todo Replace with actual database queries in Milestone 3
 * @todo Implement proper ORM or database abstraction layer
 */

/**
 * @class AppModel
 * @brief Provides demo data arrays simulating database tables
 * 
 * Simulates the following database tables:
 * - venues: Event locations with capacity
 * - events: Scheduled events with full details
 * - registrations: User registrations for events
 * - users: System users (admins and attendees)
 * 
 * @note This class is used by ALL controllers when no specific model exists
 * @note Extends Model to inherit validation/sanitization methods
 * @see Controller::model() Falls back to AppModel when specific model not found
 */
class AppModel extends Model {
  
  /**
   * @brief Get all venues (demo data)
   * 
   * @return array Array of venue records
   * 
   * @details Venue record structure:
   * - venue_id: int - Unique identifier (primary key)
   * - name: string - Venue name for display
   * - capacity: int - Maximum attendees allowed
   * - address: string - Physical location/address
   * 
   * @note Called by:
   * - header.php: Loads $venues for all views
   * - EventController: When showing venue options
   * - VenueController: For venue management
   * - Admin views: For venue selection dropdowns
   * 
   * @example Usage:
   * ```php
   * $model = new AppModel();
   * $venues = $model->venues();
   * foreach ($venues as $venue) {
   *     echo $venue['name'] . ' (Capacity: ' . $venue['capacity'] . ')';
   * }
   * ```
   */
  public function venues(): array {
    return [
      [
        'venue_id' => 1,
        'name' => 'San Francisco Convention Center',
        'capacity' => 500,
        'address' => '747 Howard St, San Francisco, CA 94103'
      ],
      [
        'venue_id' => 2,
        'name' => 'Tech Hub Downtown',
        'capacity' => 30,
        'address' => '123 Market St, San Francisco, CA 94105'
      ],
      [
        'venue_id' => 3,
        'name' => 'Rooftop Lounge, Innovation District',
        'capacity' => 100,
        'address' => '456 Mission St, San Francisco, CA 94105'
      ],
      [
        'venue_id' => 4,
        'name' => 'Innovation Center',
        'capacity' => 300,
        'address' => '789 Folsom St, San Francisco, CA 94107'
      ],
      [
        'venue_id' => 5,
        'name' => 'DevSpace Co-working',
        'capacity' => 25,
        'address' => '321 Bryant St, San Francisco, CA 94107'
      ],
    ];
  }

  /**
   * @brief Get all events (demo data with denormalized venue info)
   * 
   * @return array Array of event records with enriched data
   * 
   * @details Event record structure (denormalized for convenience):
   * Core Fields:
   * - event_id: int - Unique identifier (primary key)
   * - name: string - Event title/name
   * - description: string - Detailed event description
   * 
   * Date/Time Fields:
   * - date: string - Event date (Y-m-d format) for display
   * - time: string - Start time (12-hour format) for display
   * - end_time: string - End time (12-hour format) for display
   * - start_date: datetime - Full start timestamp for sorting
   * - end_date: datetime - Full end timestamp for calculations
   * 
   * Capacity/Registration:
   * - allowed_number: int - Maximum registrations allowed
   * - registration_count: int - Current registration count
   * 
   * Venue Fields (denormalized for convenience):
   * - venue_id: int - Foreign key to venues table
   * - venue_name: string - Venue name (duplicated for convenience)
   * - venue_capacity: int - Venue max capacity (duplicated)
   * 
   * Additional Fields:
   * - type: string - Event type (conference/workshop/networking)
   * - price: float - Registration price in USD (0 = free)
   * - organizer: string - Organization hosting the event
   * 
   * @note Called by:
   * - header.php: Provides $events to all views
   * - EventController: For event listings and details
   * - UserController: For user dashboard
   * - AdminController: For event management
   * 
   * @example Finding events by type:
   * ```php
   * $model = new AppModel();
   * $allEvents = $model->events();
   * $workshops = array_filter($allEvents, function($e) {
   *     return $e['type'] === 'workshop';
   * });
   * ```
   * 
   * @todo In production, this would be a database query with JOINs
   */
  public function events(): array {
    return [
      [
        'event_id' => 1,
        'name' => 'React Summit 2024',
        'description' => 'The biggest React conference featuring latest trends',
        'date' => '2025-03-15',
        'time' => '09:00 AM',
        'end_time' => '06:00 PM',
        'start_date' => '2025-03-15 09:00:00',
        'end_date' => '2025-03-15 18:00:00',
        'allowed_number' => 500,
        'venue_id' => 1,
        'venue_name' => 'San Francisco Convention Center',  // Denormalized
        'venue_capacity' => 500,  // Denormalized
        'registration_count' => 342,  // Current registrations
        'type' => 'conference',
        'price' => 299,
        'organizer' => 'React Foundation'
      ],
      [
        'event_id' => 2,
        'name' => 'Advanced TypeScript Workshop',
        'description' => 'Deep dive into TypeScript patterns and best practices',
        'date' => '2025-03-22',
        'time' => '10:00 AM',
        'end_time' => '04:00 PM',
        'start_date' => '2025-03-22 10:00:00',
        'end_date' => '2025-03-22 16:00:00',
        'allowed_number' => 30,
        'venue_id' => 2,
        'venue_name' => 'Tech Hub Downtown',
        'venue_capacity' => 30,
        'registration_count' => 28,
        'type' => 'workshop',
        'price' => 149,
        'organizer' => 'TypeScript Guild'
      ],
      [
        'event_id' => 3,
        'name' => 'Tech Leaders Networking Event',
        'description' => 'Connect with tech leaders and build professional relationships',
        'date' => '2025-03-28',
        'time' => '06:00 PM',
        'end_time' => '09:00 PM',
        'start_date' => '2025-03-28 18:00:00',
        'end_date' => '2025-03-28 21:00:00',
        'allowed_number' => 100,
        'venue_id' => 3,
        'venue_name' => 'Rooftop Lounge, Innovation District',
        'venue_capacity' => 100,
        'registration_count' => 67,
        'type' => 'networking',
        'price' => 75,
        'organizer' => 'TechLeaders Network'
      ],
      [
        'event_id' => 4,
        'name' => 'AI & Machine Learning Conference',
        'description' => 'Explore latest AI and ML developments with industry experts',
        'date' => '2025-04-05',
        'time' => '09:00 AM',
        'end_time' => '05:00 PM',
        'start_date' => '2025-04-05 09:00:00',
        'end_date' => '2025-04-05 17:00:00',
        'allowed_number' => 300,
        'venue_id' => 4,
        'venue_name' => 'Innovation Center',
        'venue_capacity' => 300,
        'registration_count' => 245,
        'type' => 'conference',
        'price' => 399,
        'organizer' => 'AI Research Institute'
      ],
      [
        'event_id' => 5,
        'name' => 'Web Performance Optimization Workshop',
        'description' => 'Learn advanced web optimization techniques',
        'date' => '2025-04-12',
        'time' => '01:00 PM',
        'end_time' => '05:00 PM',
        'start_date' => '2025-04-12 13:00:00',
        'end_date' => '2025-04-12 17:00:00',
        'allowed_number' => 25,
        'venue_id' => 5,
        'venue_name' => 'DevSpace Co-working',
        'venue_capacity' => 25,
        'registration_count' => 22,
        'type' => 'workshop',
        'price' => 99,
        'organizer' => 'Performance Guild'
      ],
    ];
  }

  /**
   * @brief Get all registrations (demo data)
   * 
   * @return array Array of registration records
   * 
   * @details Registration record structure:
   * - attendee_id: int - User ID who registered (foreign key to users)
   * - event_id: int - Event they registered for (foreign key to events)
   * - paid: bool - Payment status (1=paid, 0=unpaid)
   * 
   * @note Called by:
   * - header.php: Provides $registrations to all views
   * - Views: To check if current user is registered for events
   * - Future: Calculate attendance statistics
   * 
   * @example Check if user is registered:
   * ```php
   * $userId = $_SESSION['user']['id'];
   * $eventId = 1;
   * $registered = array_filter($registrations, function($r) use ($userId, $eventId) {
   *     return $r['attendee_id'] == $userId && $r['event_id'] == $eventId;
   * });
   * ```
   * 
   * @todo Add more fields:
   * - registration_date: When registered
   * - confirmation_code: Unique registration code
   * - attendance_status: checked_in, no_show, etc.
   * - payment_method: credit_card, paypal, etc.
   */
  public function registrations(): array {
    return [
      ['attendee_id' => 999, 'event_id' => 1, 'paid' => 1],
      ['attendee_id' => 999, 'event_id' => 3, 'paid' => 1],
      ['attendee_id' => 1000, 'event_id' => 2, 'paid' => 0],
    ];
  }

  /**
   * @brief Get all users (demo data)
   * 
   * @return array Array of user records
   * 
   * @details User record structure:
   * - attendee_id: int - Unique user identifier (primary key)
   * - first_name: string - User's first name
   * - last_name: string - User's last name
   * - email: string - Email address (would be unique in DB)
   * - username: string - Login username (would be unique in DB)
   * - role: string - User role (admin/attendee)
   * 
   * @note Called by:
   * - header.php: Provides $users to all views
   * - Admin views: For user management
   * - Statistics: User counts and analytics
   * 
   * @warning Passwords NOT included for security
   * @warning In production, passwords would be hashed with bcrypt
   * 
   * @example Count users by role:
   * ```php
   * $model = new AppModel();
   * $users = $model->users();
   * $admins = array_filter($users, fn($u) => $u['role'] === 'admin');
   * $attendees = array_filter($users, fn($u) => $u['role'] === 'attendee');
   * echo "Admins: " . count($admins);
   * echo "Attendees: " . count($attendees);
   * ```
   * 
   * @todo In production:
   * - Add password_hash field
   * - Add created_at, updated_at timestamps
   * - Add email_verified boolean
   * - Add profile_image, bio, etc.
   */
  public function users(): array {
    return [
      [
        'attendee_id' => 1,
        'first_name' => 'Gordon',
        'last_name' => 'Freeman',
        'email' => 'gordon@blackmesa.com',
        'username' => 'admin',
        'role' => 'admin'
      ],
      [
        'attendee_id' => 2,
        'first_name' => 'Alyx',
        'last_name' => 'Vance',
        'email' => 'alyx@resistance.com',
        'username' => 'alyx',
        'role' => 'attendee'
      ],
      [
        'attendee_id' => 3,
        'first_name' => 'Chell',
        'last_name' => 'Subject',
        'email' => 'test@aperture.com',
        'username' => 'chell',
        'role' => 'attendee'
      ],
      [
        'attendee_id' => 4,
        'first_name' => 'Marcus',
        'last_name' => 'Fenix',
        'email' => 'marcus@cog.mil',
        'username' => 'marcus',
        'role' => 'attendee'
      ],
      [
        'attendee_id' => 5,
        'first_name' => 'Master',
        'last_name' => 'Chief',
        'email' => 'john117@unsc.mil',
        'username' => 'chief',
        'role' => 'attendee'
      ],
    ];
  }
}
