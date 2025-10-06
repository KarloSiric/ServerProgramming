<?php
/**
 * Session.php - Session Management Service
 * 
 * Provides centralized session handling with timeout functionality.
 * Manages session lifecycle including initialization, expiration checking,
 * and secure destruction with proper cookie cleanup.
 * 
 * @author Karlo Siric
 * @version 1.0
 */

declare(strict_types=1);

/**
 * Final class Session
 * 
 * Static utility class for managing user sessions with automatic
 * timeout and secure cookie configuration.
 */
final class Session
{
    /**
     * Get session timeout value from configuration
     * 
     * Reads the session_timeout value from config.ini and ensures
     * it's a positive integer. Defaults to 300 seconds (5 minutes).
     * 
     * @return int Session timeout in seconds
     */
    private static function timeout(): int
    {
        $ini = parse_ini_file(CONFIG_PATH . '/config.ini', true) ?: [];
        $t = (int)($ini['session']['session_timeout'] ?? 300);
        return max(1, $t);
    }

    /**
     * Start a new session or resume existing one
     * 
     * Initializes a PHP session with secure cookie parameters if one
     * doesn't already exist. Sets last_activity_time for timeout tracking.
     * 
     * Security features:
     * - HttpOnly cookies to prevent XSS attacks
     * - Secure flag for HTTPS connections
     * - SameSite=Lax to prevent CSRF attacks
     * 
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configure secure cookie parameters
            $p = session_get_cookie_params();
            session_set_cookie_params([
                'lifetime' => 0,  // Session cookie (expires when browser closes)
                'path'     => $p['path'],
                'domain'   => $p['domain'],
                'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        // Initialize last activity timestamp on first access
        if (!isset($_SESSION['last_activity_time'])) {
            $_SESSION['last_activity_time'] = time();
        }
    }

    /**
     * Check if session has expired
     * 
     * Compares current time against last_activity_time to determine
     * if the session has exceeded the configured timeout period.
     * Automatically updates the activity timestamp if session is still valid.
     * 
     * @return bool True if session expired, false if still valid
     */
    public static function isExpired(): bool
    {
        $last = $_SESSION['last_activity_time'] ?? null;
        if ($last !== null && (time() - (int)$last) > self::timeout()) {
            return true;
        }
        // Session still valid - refresh activity timestamp
        $_SESSION['last_activity_time'] = time();
        return false;
    }

    /**
     * Destroy session and clean up
     * 
     * Completely destroys the current session, clears all session data,
     * removes the session cookie, and redirects to the login page.
     * 
     * This method should be called on logout or session expiration.
     * 
     * @return void (exits via redirect)
     */
    public static function destroy(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            // Clear all session variables
            $_SESSION = [];
            
            // Delete the session cookie
            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,  // Set expiration in the past
                    $p['path'],
                    $p['domain'],
                    $p['secure'],
                    $p['httponly']
                );
            }
            
            // Destroy the session file
            session_destroy();
        }

        // Redirect to login page
        header('Location: ' . PROJECT_URL . '/user/login');
        exit;
    }
}
