<?php
class Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ini = @parse_ini_file(CONFIG_PATH . '/config.ini', true) ?: [];
        $timeout = (int)($ini['session']['session_timeout'] ?? 300);
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - (int)$_SESSION['LAST_ACTIVITY']) > $timeout) {
            session_unset(); session_destroy();
            header('Location: ' . PROJECT_URL . '/index.php?controller=user&action=login');
            exit();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    protected function render(string $viewRelPath, array $data = []): void
    {
        extract($data);
        require 'app/view/inc/header.php';
        require 'app/view/' . ltrim($viewRelPath, '/');
        require 'app/view/inc/footer.php';
    }

    protected function redirect(string $controller, string $action, array $params = []): void
    {
        $qs = http_build_query(['controller' => $controller, 'action' => $action] + $params);
        header('Location: ' . PROJECT_URL . '/index.php?' . $qs);
        exit;
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('user', 'login');
        }
    }

    protected function requireRole(string $role): void
    {
        $this->requireLogin();
        if (($_SESSION['user']['role_name'] ?? '') !== $role) {
            $this->redirect('user', 'login');
        }
    }
}
