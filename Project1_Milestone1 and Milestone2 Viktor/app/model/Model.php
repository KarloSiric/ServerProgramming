<?php
// base model: input hygiene + simple validation helpers
class Model {

  // basic sanitizer for scalars and arrays; trim/tags/entities
  protected function sanitize($data): mixed {
    if (is_array($data)) {
      foreach ($data as $key => $value) { $data[$key] = $this->sanitize($value); }
    } else {
      $data = htmlspecialchars(strip_tags(trim($data)));
    }
    return $data;
  }

  // micro-rule engine for single value validation; extend later as needed
  protected function validate(mixed $data, array $rules): bool {
    foreach ($rules as $rule => $value) {
      switch ($rule) {
        case 'required':
          if (empty($data)) return false; break;
        case 'min_length':
          if (strlen($data) < $value) return false; break;
        case 'max_length':
          if (strlen($data) > $value) return false; break;
        case 'numeric':
          if ($value && !is_numeric($data)) return false; break;
        case 'email':
          if ($value && !filter_var($data, FILTER_VALIDATE_EMAIL)) return false; break;
        case 'regex':
          if (!preg_match($value, $data)) return false; break;
      }
    }
    return true;
  }

  // validate an associative array using a matching rules map
  public function validateInputs(array $data, array $rules): bool {
    foreach ($data as $key => $value) {
      if (isset($rules[$key]) && !$this->validate($value, $rules[$key])) return false;
    }
    return true;
  }
}
