<?php
/**
 * Base Model - aligned with professors structure
 */
class Model
{
    protected $db; // Database connection

    public function __construct()
    {
        // Establish DB connection 
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Sanitize input data
     */
    public function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize($value);
            }
        } else {
            $data = htmlspecialchars(strip_tags(trim($data)));
        }
        return $data;
    }

    /**
     * Validate input
     */
    protected function validate($data, array $rules): bool
    {
        foreach ($rules as $rule => $value) {
            switch ($rule) {
                case 'required':
                    if (empty($data)) return false;
                    break;
                case 'min_length':
                    if (strlen($data) < $value) return false;
                    break;
                case 'max_length':
                    if (strlen($data) > $value) return false;
                    break;
                case 'numeric':
                    if ($value && !is_numeric($data)) return false;
                    break;
                case 'email':
                    if ($value && !filter_var($data, FILTER_VALIDATE_EMAIL)) return false;
                    break;
                case 'regex':
                    if (!preg_match($value, $data)) return false;
                    break;
            }
        }
        return true;
    }
}
