<?php
// Base controller: automatic view resolution and model loading like your friend's system
class Controller 
{
    // Automatic model resolution - AdminController gets AdminModel, etc.
    public function model() {
        // Convert FooController -> FooModel; if missing, fall back to primary models
        $modelName = str_replace("Controller", "Model", get_class($this));
        
        // If the specific model doesn't exist, use the appropriate fallback
        if (!class_exists($modelName)) {
            // Map to your existing models based on controller type
            switch (true) {
                case str_contains(get_class($this), 'Event'):
                    $modelName = 'EventModel';
                    break;
                case str_contains(get_class($this), 'User'):
                    $modelName = 'UserModel';
                    break;
                case str_contains(get_class($this), 'Venue'):
                    $modelName = 'VenueModel';
                    break;
                default:
                    $modelName = 'EventModel'; // Default fallback
            }
        }
        
        return new $modelName();
    }

    // Automatic view resolution - no more manual path specification!
    public function view($data = []) {
        // Convert AdminController::dashboard -> app/view/admin/dashboard.php
        $controller = strtolower(str_replace('Controller', '', get_called_class()));
        $action = debug_backtrace()[1]['function'];
        $viewPath = __DIR__ . "/../view/{$controller}/{$action}.php";
        
        // Check if the view file exists
        if (!file_exists($viewPath)) {
            throw new Exception("Missing view: {$viewPath}");
        }
        
        // Extract data to make variables available in views
        extract($data, EXTR_SKIP);
        
        // Auto-load model data for views
        $model = $this->model();
        
        // Include shared header
        require __DIR__ . '/../view/inc/header.php';
        
        // Include the specific view
        require $viewPath;
        
        // Include shared footer  
        require __DIR__ . '/../view/inc/footer.php';
    }
    
    // Clean role-based security system like your friend's
    protected function requireRole(string $role) {
        $userRole = $_SESSION['user']['role'] ?? 'guest';
        
        if ($userRole !== $role) {
            http_response_code(403);
            require __DIR__ . '/../view/inc/header.php';
            echo "<div class='alert alert-danger mt-3' style='margin: 20px; padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;'>";
            echo "403 – {$role} access required</div>";
            require __DIR__ . '/../view/inc/footer.php';
            exit;
        }
    }
    
    // Convenience methods for backward compatibility
    protected function requireLogin(): void {
        if (empty($_SESSION['user'])) {
            header("Location: ?user/login");
            exit;
        }
    }
    
    protected function requireAdmin(): void {
        $this->requireRole('admin');
    }
    
    protected function userOrNull(): ?array {
        return $_SESSION['user'] ?? null;
    }
    
    // Simple redirect helper
    protected function redirect(string $path): void {
        // Clean redirect - if it starts with ?, use as-is, otherwise add ?
        if (substr($path, 0, 1) !== '?') {
            $path = '?' . ltrim($path, '/');
        }
        header("Location: $path");
        exit;
    }
}
