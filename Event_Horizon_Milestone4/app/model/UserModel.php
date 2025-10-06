<?php
/**
 * UserModel.php - User Data Access Layer
 * 
 * Handles all database operations related to users (attendees) including:
 * - User authentication and password verification
 * - User registration with password hashing
 * - Role management
 * - Attendee list retrieval for events
 * 
 * Security Features:
 * - Passwords are hashed using PHP's password_hash() function
 * - Password verification uses password_verify() for timing-attack resistance
 * - Prepared statements prevent SQL injection attacks
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class UserModel
 * 
 * Model class for managing user/attendee data in the database.
 * Extends the base Model class to inherit database connectivity.
 */
class UserModel extends Model
{
    /**
     * Authenticate user by username and password
     * 
     * Verifies user credentials against the database. Password is verified
     * using password_verify() which compares the provided password against
     * the stored hash in a timing-attack resistant manner.
     * 
     * The returned user array includes:
     * - id: User's attendee_id
     * - username: Login username
     * - email: User's email address
     * - role_name: User's role (admin, attendee, etc.)
     * 
     * @param string $username The username to authenticate
     * @param string $password The plaintext password to verify
     * @return array|null User data array on success, null on failure
     */
    public function authenticate(string $username, string $password): ?array
    {
        $sql = "SELECT a.attendee_id, a.username, a.email, a.password, r.name AS role_name
                FROM attendee a
                JOIN role r ON r.role_id = a.role_id
                WHERE a.username = :un LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':un' => $username]);
        $row = $stmt->fetch();
        
        // Verify password hash
        if ($row && password_verify($password, (string)$row['password'])) {
            return [
                'id'        => (int)$row['attendee_id'],
                'username'  => $row['username'],
                'email'     => $row['email'],
                'role_name' => $row['role_name'],
            ];
        }
        return null;
    }

    /**
     * Register a new user/attendee
     * 
     * Creates a new user account with hashed password. Performs validation
     * and checks for duplicate usernames/emails before insertion.
     * 
     * Validation:
     * - All required fields must be present (username, password, email)
     * - Username and email must be unique
     * 
     * Password Security:
     * - Uses password_hash() with PASSWORD_DEFAULT algorithm
     * - Automatically selects strongest available algorithm
     * - Handles salt generation and cost automatically
     * 
     * ID Generation:
     * - Manually generates attendee_id using MAX(attendee_id) + 1
     * - Works without AUTO_INCREMENT on the database column
     * 
     * @param array $d Associative array of user data (first_name, last_name, email, username, password, role_id)
     * @return bool|string True on success, error message string on failure
     */
    public function register(array $d)
    {
        // Validate required fields
        if (empty($d['username']) || empty($d['password']) || empty($d['email'])) {
            return "All fields are required.";
        }

        // Check for duplicate username or email
        $sql = "SELECT COUNT(*) FROM attendee WHERE username = :un OR email = :em";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':un' => $d['username'], ':em' => $d['email']]);
        if ($stmt->fetchColumn() > 0) {
            return "Username or email already exists.";
        }

        // Generate next available attendee_id
        $sql = "SELECT COALESCE(MAX(attendee_id), 0) + 1 AS next_id FROM attendee";
        $stmt = $this->db->query($sql);
        $nextId = (int)$stmt->fetchColumn();

        // Insert new user with hashed password
        $sql = "INSERT INTO attendee(attendee_id, first_name, last_name, email, username, password, role_id)
                VALUES(:id, :fn, :ln, :email, :un, :pw, :role)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':id'    => $nextId,
            ':fn'    => $d['first_name'] ?? '',
            ':ln'    => $d['last_name'] ?? '',
            ':email' => $d['email'],
            ':un'    => $d['username'],
            ':pw'    => password_hash($d['password'], PASSWORD_DEFAULT),  // Hash password
            ':role'  => $d['role_id'] ?? 2,  // Default to attendee role
        ]);
        
        return $success ? true : "Registration failed.";
    }

    /**
     * Get all available user roles
     * 
     * Retrieves the list of all roles from the database for use in
     * registration forms or role management interfaces.
     * 
     * Typically returns roles like:
     * - role_id: 1, name: 'admin'
     * - role_id: 2, name: 'attendee'
     * 
     * @return array Array of role records with role_id and name
     */
    public function getRoles(): array
    {
        $sql = "SELECT role_id, name FROM role ORDER BY role_id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get list of attendees registered for an event
     * 
     * Retrieves all users who have registered for a specific event.
     * Joins attendee_event table with attendee table to get user details.
     * 
     * Returned data includes:
     * - attendee_id: User's unique ID
     * - first_name: User's first name
     * - last_name: User's last name
     * - username: User's login username
     * - email: User's email address
     * 
     * Results are sorted alphabetically by last name, then first name.
     * 
     * @param int $eventId The event ID to get attendees for
     * @return array Array of attendee records
     */
    public function getAttendees(int $eventId): array
    {
        $sql = "SELECT a.attendee_id, a.first_name, a.last_name, a.username, a.email
                FROM attendee_event ae
                JOIN attendee a ON a.attendee_id = ae.attendee_id
                WHERE ae.event_id = :eid
                ORDER BY a.last_name, a.first_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':eid' => $eventId]);
        return $stmt->fetchAll();
    }
}
