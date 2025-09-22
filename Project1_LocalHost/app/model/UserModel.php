<?php

/**
 * Represents a user entity extending the Model class for database interaction.
 */
class UserModel extends Model {

    /**
     * @var int $id The ID of the user.
     */
    private $id;

    /**
     * @var string $username The username of the user.
     */
    private $username;

    /**
     * @var string $email The email of the user.
     */
    private $email;

    /**
     * @var string $password_hash The hashed password of the user.
     */
    private $password_hash;

    /**
     * @var string $name The name of the user.
     */
    private $name;

    /**
     * @var string $role The role of the user.
     */
    private $role;

    /**
     * Returns a string representation of the user.
     *
     * @return string The string representation of the user.
     */
    public function __toString() {
        return "I am {$this->name} ({$this->username}) and my role is {$this->role}";
    }

    /**
     * Authenticates a user by username/email and password
     *
     * @param string $username The username or email
     * @param string $password The plain text password
     * @return array|null The user data if authenticated, null otherwise
     */
    public function authenticate(string $username, string $password): ?array {
        $username = trim($username);
        if ($username === '') {
            return null;
        }
        
        // Query database for user by username or email
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $user = $this->fetchOne($query, [$username, $username]);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'email' => $user['email'],
                'name' => $user['name'],
            ];
        }
        
        return null;
    }

    /**
     * Creates a new user in the database
     *
     * @param string $name The full name
     * @param string $email The email address
     * @param string $password The plain text password
     * @param bool $isAdmin Whether user should be admin
     * @return bool True if user created successfully
     */
    public function createUser(string $name, string $email, string $password, bool $isAdmin = false): bool {
        // Check if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $existingUser = $this->fetchOne($checkQuery, [$email]);
        
        if ($existingUser) {
            return false; // Email already exists
        }
        
        // Hash password properly
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Create username from email
        $username = strtolower(explode('@', $email)[0]);
        
        // Ensure username is unique
        $originalUsername = $username;
        $counter = 1;
        while (true) {
            $checkUsernameQuery = "SELECT id FROM users WHERE username = ?";
            $existingUsername = $this->fetchOne($checkUsernameQuery, [$username]);
            if (!$existingUsername) {
                break;
            }
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        // Insert into database
        $insertQuery = "INSERT INTO users (username, email, password_hash, name, role) VALUES (?, ?, ?, ?, ?)";
        $role = $isAdmin ? 'admin' : 'user';
        
        try {
            $this->query($insertQuery, [$username, $email, $hashedPassword, $name, $role]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Retrieves all users from the database.
     *
     * @return array The array of user data.
     */
    public function getAllUsers(): array {
        return $this->fetchAll('SELECT id, username, email, name, role, created_at FROM users ORDER BY created_at DESC');
    }

    /**
     * Retrieves all users with a specific role from the database.
     *
     * @param string $role The role to filter by.
     * @return array The array of user data.
     */
    public function getAllByRole(string $role): array {
        return $this->fetchAll('SELECT * FROM users WHERE role = ? ORDER BY username ASC', [$role]);
    }

    /**
     * Retrieves a user by their ID from the database.
     *
     * @param int $id The ID of the user.
     * @return array|null The user data if found, null otherwise.
     */
    public function getById(int $id): ?array {
        return $this->fetchOne('SELECT * FROM users WHERE id = ?', [$id]);
    }

    /**
     * Updates a user's information in the database.
     *
     * @param int $id The user ID
     * @param string $name The new name
     * @param string $email The new email
     * @param string $role The new role
     * @return bool True if updated successfully
     */
    public function updateUser(int $id, string $name, string $email, string $role): bool {
        $updateQuery = "UPDATE users SET name = ?, email = ?, role = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        
        try {
            $rowsAffected = $this->query($updateQuery, [$name, $email, $role, $id]);
            return $rowsAffected > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Deletes a user from the database.
     *
     * @param int $id The user ID
     * @return bool True if deleted successfully
     */
    public function deleteUser(int $id): bool {
        try {
            $rowsAffected = $this->query("DELETE FROM users WHERE id = ?", [$id]);
            return $rowsAffected > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Gets user statistics from the database
     *
     * @return array Statistics array
     */
    public function getUserStats(): array {
        $totalResult = $this->fetchOne("SELECT COUNT(*) as total FROM users");
        $adminResult = $this->fetchOne("SELECT COUNT(*) as admins FROM users WHERE role = 'admin'");
        
        $total = $totalResult['total'];
        $admins = $adminResult['admins'];
        $users = $total - $admins;
        
        return [
            'total' => $total,
            'admins' => $admins,
            'users' => $users,
            'new_today' => rand(1, 5), // Mock data for now
            'active_sessions' => rand(10, 50), // Mock data for now
        ];
    }

    /**
     * Gets recent user activity (mock data for now)
     *
     * @return array Activity array
     */
    public function getRecentActivity(): array {
        // Mock recent user activity - can be enhanced later
        return [
            [
                'user' => 'Sarah Chen',
                'email' => 'sarah.chen@email.com',
                'action' => 'Registered for React Summit 2024',
                'time' => '2 min ago',
                'avatar' => 'SC'
            ],
            [
                'user' => 'Mike Johnson',
                'email' => 'mike.j@company.com',
                'action' => 'Created account',
                'time' => '5 min ago',
                'avatar' => 'MJ'
            ],
            [
                'user' => 'Alex Rivera',
                'email' => 'alex.rivera@startup.io',
                'action' => 'Updated profile',
                'time' => '12 min ago',
                'avatar' => 'AR'
            ],
            [
                'user' => 'Emma Wilson',
                'email' => 'emma.w@enterprise.com',
                'action' => 'Registered for TypeScript Workshop',
                'time' => '18 min ago',
                'avatar' => 'EW'
            ],
        ];
    }
}
