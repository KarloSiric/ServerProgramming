<?php
// Base model class with input sanitization and validation helpers
// Provides foundation for EventModel, UserModel, and VenueModel
abstract class Model {

    // Clean and sanitize input data - handles both single values and arrays
    protected function sanitize($data): mixed {
        if (is_array($data)) {
            foreach ($data as $key => $value) { 
                $data[$key] = $this->sanitize($value); 
            }
        } else {
            $data = htmlspecialchars(strip_tags(trim($data)));
        }
        return $data;
    }

    // Flexible validation engine - can be extended for any validation rules
    protected function validate(mixed $data, array $rules): bool {
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

    // Validate multiple fields at once using rule mapping
    public function validateInputs(array $data, array $rules): bool {
        foreach ($data as $key => $value) {
            if (isset($rules[$key]) && !$this->validate($value, $rules[$key])) {
                return false;
            }
        }
        return true;
    }
}
