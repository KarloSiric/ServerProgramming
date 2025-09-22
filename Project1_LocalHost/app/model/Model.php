<?php
/**
 * Base Model class with PDO database connectivity
 * Provides common database operations for all models
 * 
 * @author Updated for Milestone 3 that is due to next week
 */
abstract class Model
{
    protected PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Execute a prepared statement with parameters
     * 
     * @param string $query SQL query with placeholders
     * @param array $params Parameters to bind
     * @return PDOStatement
     */
    protected function execute(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Fetch single row from database
     * 
     * @param string $query SQL query
     * @param array $params Parameters
     * @return array|null
     */
    protected function fetchOne(string $query, array $params = []): ?array
    {
        $stmt = $this->execute($query, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Fetch all rows from database
     * 
     * @param string $query SQL query
     * @param array $params Parameters
     * @return array
     */
    protected function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->execute($query, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Get last inserted ID
     * 
     * @return string
     */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}
