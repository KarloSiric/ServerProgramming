<?php
/**
 * @file Model.php
 * @brief Base model class providing data validation and sanitization
 * 
 * Foundation for all model classes in the application.
 * Provides input hygiene and validation methods to ensure data integrity
 * and prevent security vulnerabilities like XSS attacks.
 * 
 * @author KarloSiric
 * @version 1.0
 * @date 2025
 * 
 * @details Model Responsibilities:
 * 1. Data validation before storage
 * 2. Input sanitization for security
 * 3. Business logic and rules
 * 4. Data transformation
 * 5. Future: Database interactions
 */

/**
 * @class Model
 * @brief Abstract base model with input validation and sanitization
 * 
 * Features:
 * - Input sanitization (XSS prevention)
 * - Flexible validation rules engine
 * - Array and scalar data handling
 * - Extensible validation system
 * 
 * @note All models SHOULD extend this class for security
 * @note This is a micro-framework approach - simple but effective
 */
class Model {

  /**
   * @brief Sanitize input data to prevent XSS attacks
   * 
   * @param mixed $data Scalar value or array to sanitize
   * @return mixed Sanitized data in same format as input
   * 
   * @details Sanitization process:
   * 1. If array: recursively sanitize each element
   * 2. If scalar: apply sanitization chain:
   *    a. trim() - Remove leading/trailing whitespace
   *    b. strip_tags() - Remove HTML/PHP tags
   *    c. htmlspecialchars() - Convert special chars to HTML entities
   * 
   * @example Basic usage:
   * ```php
   * // Sanitize single value
   * $clean = $this->sanitize($_POST['user_input']);
   * // Input: "<script>alert('XSS')</script>"
   * // Output: "&lt;script&gt;alert('XSS')&lt;/script&gt;"
   * 
   * // Sanitize entire array
   * $cleanData = $this->sanitize($_POST);
   * ```
   * 
   * @note This prevents XSS by encoding dangerous characters
   * @warning This is basic sanitization - for production, consider:
   * - HTML Purifier for rich text
   * - Filter functions (filter_var)
   * - Context-specific encoding
   */
  protected function sanitize($data): mixed {
    if (is_array($data)) {
      /**
       * Recursively sanitize each array element
       * This handles nested arrays too
       * 
       * Example:
       * ['name' => 'John', 'address' => ['street' => '123 Main']]
       * Both 'name' and 'address[street]' get sanitized
       */
      foreach ($data as $key => $value) { 
        $data[$key] = $this->sanitize($value); 
      }
    } else {
      /**
       * For scalar values, apply sanitization chain:
       * 
       * 1. trim() - Remove whitespace
       *    "  hello  " → "hello"
       * 
       * 2. strip_tags() - Remove HTML/PHP tags
       *    "<b>hello</b>" → "hello"
       * 
       * 3. htmlspecialchars() - Convert special chars
       *    "<script>" → "&lt;script&gt;"
       *    Prevents browser from executing as HTML
       */
      $data = htmlspecialchars(strip_tags(trim($data)));
    }
    return $data;
  }

  /**
   * @brief Validate a single value against a set of rules
   * 
   * @param mixed $data The value to validate
   * @param array $rules Associative array of validation rules
   * @return bool True if all rules pass, false otherwise
   * 
   * @details Supported validation rules:
   * - 'required' => true : Value must not be empty
   * - 'min_length' => n : String must be at least n characters
   * - 'max_length' => n : String must be at most n characters  
   * - 'numeric' => true : Value must be numeric
   * - 'email' => true : Value must be valid email format
   * - 'regex' => '/pattern/' : Value must match regex pattern
   * 
   * @example Complete validation example:
   * ```php
   * // Define validation rules
   * $emailRules = [
   *   'required' => true,
   *   'email' => true,
   *   'max_length' => 100
   * ];
   * 
   * // Validate the input
   * if ($this->validate($_POST['email'], $emailRules)) {
   *   // Email is valid - proceed with registration
   * } else {
   *   // Validation failed - show error
   * }
   * 
   * // Custom regex example
   * $usernameRules = [
   *   'required' => true,
   *   'min_length' => 3,
   *   'max_length' => 20,
   *   'regex' => '/^[a-zA-Z0-9_]+$/'  // Alphanumeric + underscore only
   * ];
   * ```
   * 
   * @note Rules are processed in order - first failure stops validation
   * @internal This is a micro-rule engine - easily extensible
   */
  protected function validate(mixed $data, array $rules): bool {
    foreach ($rules as $rule => $value) {
      switch ($rule) {
        case 'required':
          /**
           * Check if value is not empty
           * empty() returns true for: "", 0, "0", NULL, FALSE, array()
           */
          if (empty($data)) return false; 
          break;
          
        case 'min_length':
          /**
           * Check minimum string length
           * strlen() counts bytes, not characters
           * For multibyte strings, use mb_strlen()
           */
          if (strlen($data) < $value) return false; 
          break;
          
        case 'max_length':
          /**
           * Check maximum string length
           * Prevents database field overflow
           */
          if (strlen($data) > $value) return false; 
          break;
          
        case 'numeric':
          /**
           * Check if value is numeric
           * Only validates if rule is set to true
           * is_numeric accepts: "123", 123, "123.45", etc.
           */
          if ($value && !is_numeric($data)) return false; 
          break;
          
        case 'email':
          /**
           * Validate email format using PHP filter
           * FILTER_VALIDATE_EMAIL checks RFC compliance
           * More reliable than regex for email validation
           */
          if ($value && !filter_var($data, FILTER_VALIDATE_EMAIL)) return false; 
          break;
          
        case 'regex':
          /**
           * Match against custom regex pattern
           * Allows complex custom validation
           * Example: '/^[A-Z]{2}[0-9]{4}$/' for ID format
           */
          if (!preg_match($value, $data)) return false; 
          break;
          
        // Easy to add more rules here:
        // case 'url':
        // case 'date':
        // case 'in_array':
        // etc.
      }
    }
    return true;  // All rules passed
  }

  /**
   * @brief Validate multiple inputs using a rules map
   * 
   * @param array $data Associative array of input data (typically $_POST)
   * @param array $rules Associative array mapping field names to validation rules
   * @return bool True if all fields pass validation, false otherwise
   * 
   * @details Validates entire forms or data sets at once
   * 
   * @example Complete form validation:
   * ```php
   * // Form data from $_POST
   * $formData = [
   *   'username' => 'john_doe',
   *   'email' => 'john@example.com',
   *   'password' => 'secret123',
   *   'age' => '25'
   * ];
   * 
   * // Validation rules for each field
   * $formRules = [
   *   'username' => [
   *     'required' => true,
   *     'min_length' => 3,
   *     'max_length' => 20,
   *     'regex' => '/^[a-zA-Z0-9_]+$/'
   *   ],
   *   'email' => [
   *     'required' => true,
   *     'email' => true,
   *     'max_length' => 100
   *   ],
   *   'password' => [
   *     'required' => true,
   *     'min_length' => 8
   *   ],
   *   'age' => [
   *     'required' => true,
   *     'numeric' => true
   *   ]
   * ];
   * 
   * // Validate all at once
   * if ($this->validateInputs($formData, $formRules)) {
   *   // All inputs are valid - proceed with registration
   *   $this->createUser($formData);
   * } else {
   *   // At least one field failed validation
   *   $this->showErrors();
   * }
   * ```
   * 
   * @note Stops on first field that fails validation
   * @note Fields without rules are not validated (assumed valid)
   * 
   * @see validate() For single field validation
   * @see Controller Form controllers call this before processing
   */
  public function validateInputs(array $data, array $rules): bool {
    foreach ($data as $key => $value) {
      /**
       * Check if rules exist for this field
       * Fields without rules are skipped (assumed valid)
       * This allows partial validation of forms
       */
      if (isset($rules[$key]) && !$this->validate($value, $rules[$key])) {
        return false;  // Validation failed for this field
      }
    }
    return true;  // All validations passed
  }
}
