<?php
// Controller.php - Base controller for event management system
abstract class Controller
{
    protected function render(string $viewPath, array $data = []): void
    {
        // Extract data to make variables available in views
        extract($data, EXTR_SKIP);
        
        // Include shared header
        require __DIR__ . '/../view/inc/header.php';
        
        // Include the specific view
        require __DIR__ . '/../view/' . ltrim($viewPath, '/');
        
        // Include shared footer
        require __DIR__ . '/../view/inc/footer.php';
    }
    
    protected function redirect(string $path): void
    {
        // Convert path format to query string format for professor's router
        if (substr($path, 0, 1) === '/') {
            // Remove leading slash and convert /controller/action to ?controller/action
            $path = ltrim($path, '/');
            if ($path && strpos($path, '?') === false) {
                $path = '?' . $path;
            }
        }
        
        header("Location: $path");
        exit;
    }
    
    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('/user/login');
        }
    }
    
    protected function userOrNull(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    
    protected function requireAdmin(): void
    {
        $this->requireLogin();
        $user = $this->userOrNull();
        if (($user['role'] ?? '') !== 'admin') {
            $this->redirect('/user/dashboard');
        }
    }
}
