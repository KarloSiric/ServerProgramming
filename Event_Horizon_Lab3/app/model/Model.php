<?php
declare(strict_types=1);

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $ini = parse_ini_file(CONFIG_PATH . '/config.ini', true);
        if (!$ini || empty($ini['database'])) {
            throw new RuntimeException('Invalid or missing config/config.ini');
        }
        $db = $ini['database'];
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $db['host'], $db['name']);
        $this->db = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
}
