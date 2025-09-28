<?php
declare(strict_types=1);

abstract class Controller
{
    protected function render(string $viewRelPath, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $file = VIEW_PATH . '/' . ltrim($viewRelPath, '/');
        // Compatibility: check if string ends with ".php" without str_ends_with()
        if (substr_compare($file, '.php', -4) !== 0) {
            $file .= '.php';
        }

        if (!file_exists($file)) {
            echo "<h1>View not found:</h1><p>{$file}</p>";
            return;
        }

        include VIEW_PATH . '/inc/header.php';
        include $file;
        include VIEW_PATH . '/inc/footer.php';
    }

    protected function redirect(string $controller, string $action, array $params = []): void
    {
        $qs = http_build_query(array_merge(['controller' => $controller, 'action' => $action], $params));
        header('Location: ' . BASE_PATH . '/Index.php?' . $qs);
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
        if (empty($_SESSION['user']['role_name']) || $_SESSION['user']['role_name'] !== $role) {
            http_response_code(403);
            echo "<h1>403 Forbidden</h1>";
            exit;
        }
    }
}
