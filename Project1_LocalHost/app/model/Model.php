<?php

/**
 * Description of Model. Provides a base for dealing with input data and database 
 * interaction. When dealing with input data, sanitizing and validating inputs 
 * are crucial to ensure security and integrity. Sanitizing data means cleaning 
 * it to prevent injection attacks (like SQL injection, XSS, etc.), while validation 
 * checks if the data meets specific criteria.
 *
 * @author Kristina Marasovic <kristina.marasovic@croatia.rit.edu>
 */
class Model {

    /**
     * @var PDO $connection The PDO instance for database connection.
     */
    private $connection;

    /**
     * @var array $settings The PDO settings array.
     */
    private $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    /**
     * Model constructor. Initiates a database connection upon instantiation.
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Establishes a database connection using PDO.
     *
     * @throws PDOException if connection fails.
     */
    private function connect(): void {
        if ($this->connection == null) {
            try {
                $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
                
                $this->connection = new PDO(
                    $config['db']['dsn'],
                    $config['db']['username'],
                    $config['db']['password'],
                    $this->settings
                );
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }
        }
    }    
    /**
     * Executes a query and returns the PDOStatement object.
     *
     * @param string $query The SQL query to execute.
     * @param array $params Optional parameters for the SQL query.
     * @return PDOStatement The PDOStatement object after execution.
     * @throws PDOException if the query fails.
     */
    private function executeQuery(string $query, array $params = []): PDOStatement {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    /**
     * Executes a query and returns a single row as an object of the specified class.
     *
     * @param string $query The SQL query to execute.
     * @param string $className The name of the class to instantiate.
     * @param array $params Optional parameters for the SQL query.
     * @return object|false The resulting object or false if no rows found.
     */
    protected function queryOne(string $query, string $className, array $params = []): object|false {
        $statement = $this->executeQuery($query, $params);
        return $statement->fetchObject($className);
    }

    /**
     * Executes a query and returns all matching rows as objects of the specified class.
     *
     * @param string $query The SQL query to execute.
     * @param string $className The name of the class to instantiate.
     * @param array $params Optional parameters for the SQL query.
     * @return array The resulting array of objects.
     */
    protected function queryAll(string $query, string $className, array $params = []): array {
        $statement = $this->executeQuery($query, $params);
        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * Executes a query and returns the number of affected rows.
     *
     * @param string $query The SQL query to execute.
     * @param array $params Optional parameters for the SQL query.
     * @return int The number of affected rows.
     */
    protected function query(string $query, array $params = []): int {
        $statement = $this->executeQuery($query, $params);
        return $statement->rowCount();
    }

    /**
     * Fetch single row from database as associative array
     * 
     * @param string $query SQL query
     * @param array $params Parameters
     * @return array|null
     */
    protected function fetchOne(string $query, array $params = []): ?array
    {
        $stmt = $this->executeQuery($query, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Fetch all rows from database as associative arrays
     * 
     * @param string $query SQL query
     * @param array $params Parameters
     * @return array
     */
    protected function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get last inserted ID
     * 
     * @return string
     */
    protected function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
