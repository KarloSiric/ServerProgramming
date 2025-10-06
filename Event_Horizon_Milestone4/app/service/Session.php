<?php
declare(strict_types=1);

final class Session
{
    private static function timeout(): int
    {
        $ini = parse_ini_file(CONFIG_PATH . '/config.ini', true) ?: [];
        $t = (int)($ini['session']['session_timeout'] ?? 300);
        return max(1, $t);
    }

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Conservative cookie params
            $p = session_get_cookie_params();
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => $p['path'],
                'domain'   => $p['domain'],
                'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        // Initialize last activity time on first touch
        if (!isset($_SESSION['last_activity_time'])) {
            $_SESSION['last_activity_time'] = time();
        }
    }

    public static function isExpired(): bool
    {
        $last = $_SESSION['last_activity_time'] ?? null;
        if ($last !== null && (time() - (int)$last) > self::timeout()) {
            return true;
        }
        // Not expired ⇒ refresh activity timestamp
        $_SESSION['last_activity_time'] = time();
        return false;
    }

    public static function destroy(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $p['path'],
                    $p['domain'],
                    $p['secure'],
                    $p['httponly']
                );
            }
            session_destroy();
        }

        // Redirect to login after destroying the session
        header('Location: ' . BASE_PATH . '/Index.php?controller=user&action=login');
        exit;
    }
}
