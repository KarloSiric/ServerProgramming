<?php
/**
 * Model.php - Base Model Class
 * 
 * Abstract base class for all model classes in the application.
 * Provides database connection access to child model classes.
 * 
 * All models that interact with the database should extend this class
 * to gain access to the shared PDO connection.
 * 
 * @author Karlo Siric
 * @version 1.0
 */

/**
 * Class Model
 * 
 * Base model class that provides database connectivity to all
 * child model classes through protected property access.
 */
class Model
{
    /**
     * @var PDO $db Database connection instance
     */
    protected $db;

    /**
     * Model constructor
     * 
     * Initializes the model with a database connection from the Database singleton.
     * This connection is available to all child classes through $this->db.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
