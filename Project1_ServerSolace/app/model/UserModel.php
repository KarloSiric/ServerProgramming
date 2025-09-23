<?php
// UserModel.php - Enhanced EventHorizon users with registration
class UserModel extends Model
{
    // Users storage (in real app this would be a database)
    private array $users = [
        'admin' => [
            'password' => 'admin123', 
            'role' => 'admin', 
            'email' => 'admin@eventhorizon.com',
            'name' => 'Administrator'
        ],
        'user' => [
            'password' => 'user123', 
            'role' => 'user', 
            'email' => 'user@eventhorizon.com',
            'name' => 'Event Attendee'
        ],
        'karlo' => [
            'password' => 'karlo123', 
            'role' => 'admin', 
            'email' => 'ks123@gmail.com',
            'name' => 'karlo'
        ],
    ];
    
    public function authenticate(string $username, string $password): ?array
    {
        $username = trim($username);
        if ($username === '' || !isset($this->users[$username])) {
            return null;
        }
        
        $userData = $this->users[$username];
        if ($userData['password'] !== $password) {
            return null;
        }
        
        return [
            'username' => $username,
            'role' => $userData['role'],
            'email' => $userData['email'],
            'name' => $userData['name'],
        ];
    }
    
    public function createUser(string $name, string $email, string $password, bool $isAdmin = false): bool
    {
        // Check if email already exists
        foreach ($this->users as $userData) {
            if ($userData['email'] === $email) {
                return false;
            }
        }
        
        // Create username from email
        $username = strtolower(explode('@', $email)[0]);
        
        // Ensure username is unique
        $originalUsername = $username;
        $counter = 1;
        while (isset($this->users[$username])) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        $this->users[$username] = [
            'password' => $password,
            'role' => $isAdmin ? 'admin' : 'user',
            'email' => $email,
            'name' => $name,
        ];
        
        return true;
    }
    
    public function getAllUsers(): array
    {
        $users = [];
        foreach ($this->users as $username => $data) {
            $users[] = [
                'username' => $username,
                'role' => $data['role'],
                'email' => $data['email'],
                'name' => $data['name'],
                'created_at' => date('Y-m-d H:i:s'), // Mock data
            ];
        }
        return $users;
    }
    
    public function getUserStats(): array
    {
        $total = count($this->users);
        $admins = count(array_filter($this->users, fn($u) => $u['role'] === 'admin'));
        $users = $total - $admins;
        
        return [
            'total' => $total,
            'admins' => $admins,
            'users' => $users,
            'new_today' => rand(1, 5), // Mock data
            'active_sessions' => rand(10, 50), // Mock data
        ];
    }
    
    public function getRecentActivity(): array
    {
        // Mock recent user activity
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
    
    // Bridge method to access events - in a real app this would be through proper relationships
    public function getAllEvents(): array
    {
        // Load EventModel to get the actual event data
        $eventModel = new EventModel();
        return $eventModel->getAllEvents();
    }
    
    // User management methods for admin functionality
    public function setUserStatus(string $username, string $status): bool
    {
        if (!isset($this->users[$username])) {
            return false;
        }
        
        // In a real app, this would update the database
        // For demo purposes, we'll just return true
        return true;
    }
    
    public function deleteUser(string $username): bool
    {
        if (!isset($this->users[$username])) {
            return false;
        }
        
        // In a real app, this would delete from database
        // For demo purposes, we'll simulate deletion
        unset($this->users[$username]);
        return true;
    }
}
