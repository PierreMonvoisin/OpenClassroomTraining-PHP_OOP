<?php
class User {
  // Attributes
  private $_id;
  private $_name;
  private $_strength;
  private $_health;
  private $_level;
  private $_exp;

  // Methods
  public function hydrate(array $data) {
    // For each value in the array of data
    foreach ($data as $key => $value){
      // Create a method string with the key
      $method = 'set'. ucfirst($key);
      // Check if method exists
      if (method_exists($this, $method)){
        // Executre method with value from data
        $this->$method($value);
      }
    }
  }

  // Getters
  public function id() { return $this->_id; }
  public function name() { return $this->_name; }
  public function strength() { return $this->_strength; }
  public function health() { return $this->_health; }
  public function level() { return $this->_level; }
  public function exp() { return $this->_exp; }

  // Setters
  public function setId($id) {
    if (! is_int($id)) {
      trigger_error('ID must be a number', E_USER_WARNING);
    }
    else if ($id <= 0){
      trigger_error('ID must be superior to 0', E_USER_WARNING);
    }
    else { $this->_id = $id; }
  }

  public function setName($name) {
    if (! is_string($name)) {
      trigger_error('Name must be a string', E_USER_WARNING);
    }
    else { $this->_name = $name; }
  }

  public function setStrength($strength) {
    if (! is_int($strength)) {
      trigger_error('Strength must be a number', E_USER_WARNING);
    }
    else if ($strength <= 0 || $strength > 100){
      trigger_error('Strength must be between 1 and 100', E_USER_WARNING);
    }
    else { $this->_strength = $strength; }
  }

  public function setHealth($health) {
    if (! is_int($health)) {
      trigger_error('Health must be a number', E_USER_WARNING);
    }
    else if ($health < 0 || $health > 100){
      trigger_error('Health must be between 0 and 100', E_USER_WARNING);
    }
    else { $this->_health = $health; }
  }

  public function setLevel($level) {
    if (! is_int($level)) {
      trigger_error('Level must be a number', E_USER_WARNING);
    }
    else if ($level <= 0 || $level > 100){
      trigger_error('Level must be between 1 and 100', E_USER_WARNING);
    }
    else { $this->_level = $level; }
  }

  public function setExp($exp) {
    if (! is_int($exp)) {
      trigger_error('Experience must be a number', E_USER_WARNING);
    }
    else if ($exp <= 0 || $exp > 100){
      trigger_error('Experience must be between 1 and 100', E_USER_WARNING);
    }
    else { $this->_exp = $exp; }
  }
} ?>
