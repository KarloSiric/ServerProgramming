<?php

class UserModel extends Model
{
    /**
     * Authenticate user by username
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
     * Register new attendee - returns true on success, error string on failure
     */
    public function register(array $d)
    {
        // Basic validation
        if (empty($d['username']) || empty($d['password']) || empty($d['email'])) {
            return "All fields are required.";
        }

        // Check if username or email already exists
        $sql = "SELECT COUNT(*) FROM attendee WHERE username = :un OR email = :em";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':un' => $d['username'], ':em' => $d['email']]);
        if ($stmt->fetchColumn() > 0) {
            return "Username or email already exists.";
        }

        // Get the next available attendee_id
        $sql = "SELECT COALESCE(MAX(attendee_id), 0) + 1 AS next_id FROM attendee";
        $stmt = $this->db->query($sql);
        $nextId = (int)$stmt->fetchColumn();

        // Insert new user with explicit attendee_id
        $sql = "INSERT INTO attendee(attendee_id, first_name, last_name, email, username, password, role_id)
                VALUES(:id, :fn, :ln, :email, :un, :pw, :role)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':id'    => $nextId,
            ':fn'    => $d['first_name'] ?? '',
            ':ln'    => $d['last_name'] ?? '',
            ':email' => $d['email'],
            ':un'    => $d['username'],
            ':pw'    => password_hash($d['password'], PASSWORD_DEFAULT),
            ':role'  => $d['role_id'] ?? 2, // default attendee
        ]);
        
        return $success ? true : "Registration failed.";
    }

    /**
     * Get all roles for registration form
     */
    public function getRoles(): array
    {
        $sql = "SELECT role_id, name FROM role ORDER BY role_id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get attendees for an event
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
