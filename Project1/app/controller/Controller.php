<?php
// Controller.php - Base controller for event management system (Server compatible)
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
        // Get the base path for the application
        $basePath = $this->getBasePath();
        
        // Handle both absolute paths and relative paths
        if (substr($path, 0, 1) === '/') {
            // Remove leading slash and prepend base path
            $path = ltrim($path, '/');
            header("Location: {$basePath}{$path}");
        } else {
            header("Location: {$basePath}{$path}");
        }
        exit;
    }
    
    private function getBasePath(): string
    {
        // Get the current script path and extract the base path
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = dirname($scriptName);
        
        // Ensure trailing slash
        if (substr($basePath, -1) !== '/') {
            $basePath .= '/';
        }
        
        return $basePath;
    }
    
    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('user/login');
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
            $this->redirect('user/dashboard');
        }
    }
}
