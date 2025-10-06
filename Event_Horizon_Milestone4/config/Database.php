<?php
/**
 * Database.php - Database Connection Manager
 * 
 * Provides singleton pattern database connection using PDO.
 * Reads database credentials from config.ini and establishes
 * a MySQL connection with proper error handling.
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class Database
 * 
 * Singleton class that manages a single PDO database connection
 * throughout the application lifecycle.
 */
class Database
{
    /**
     * @var PDO|null $connection Singleton PDO instance
     */
    private static $connection = null;

    /**
     * Get database connection instance
     * 
     * Returns the existing PDO connection or creates a new one if it doesn't exist.
     * Uses singleton pattern to ensure only one database connection throughout the app.
     * 
     * Connection settings:
     * - Reads credentials from CONFIG_PATH/config.ini
     * - Uses UTF-8 character set
     * - Sets error mode to exception for better error handling
     * - Returns associative arrays by default
     * 
     * @return PDO Active database connection
     * @throws PDOException If connection fails
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            // Read database configuration
            $config = parse_ini_file(CONFIG_PATH . '/config.ini', true);
            $db = $config['database'];

            // Build DSN (Data Source Name)
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4";

            // Create PDO connection with options
            self::$connection = new PDO(
                $dsn,
                $db['user'],
                $db['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Return associative arrays
                    PDO::ATTR_EMULATE_PREPARES => false  // Use real prepared statements
                ]
            );
        }

        return self::$connection;
    }
}
