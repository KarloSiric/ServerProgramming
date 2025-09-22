<?php
/**
 * Database connection class using PDO
 * Implements singleton pattern to ensure single database connection
 * 
 * @author Generated for Milestone 3
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $connection;
    
    // Database configuration
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'eventhorizon_db';
    private const DB_USER = 'root';
    private const DB_PASS = '';  // Change this to your MySQL password
    private const DB_CHARSET = 'utf8mb4';
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
            
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get database instance (singleton pattern)
     * 
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    /**
     * Get PDO connection
     * 
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
    
    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}
    
    /**
     * Prevent unserializing of the instance
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
