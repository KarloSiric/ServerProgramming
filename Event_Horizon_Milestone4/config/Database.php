<?php
/**
 * Database connection class (Singleton)
 */
class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $configFile = CONFIG_PATH . '/config.ini';
        
        if (!file_exists($configFile)) {
            die("Config file not found at: $configFile");
        }
        
        $config = parse_ini_file($configFile, true);
        
        if (!$config) {
            die("Failed to parse config.ini");
        }

        $host = $config['database']['host'] ?? 'localhost';
        $db   = $config['database']['name'] ?? '';
        $user = $config['database']['user'] ?? '';
        $pass = $config['database']['pass'] ?? '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
