<?php
class User {
  private $_id;
  private $_name;
  private $_damages;

  const FRIENDLY_FIRE = 1;
  const USER_KILLED = 2;
  const USER_HIT = 3;

  public function hit(User $userToHit) {
    if ($this->_id == $perso->id()){
      return self::FRIENDLY_FIRE;
    }
    return $userToHit->takeDamage();
  }

  public function takeDamage() {
    $this->_damages += 5;
    if ($this->_damages > 100){
      return self::USER_KILLED;
    }
    return self::USER_HIT;
  }

  public function hydrate(array $data) {
    $methodCalled = 0;
    // For each value in the array of data
    foreach ($data as $key => $value){
      // Create a method string with the key
      $method = 'set'. ucfirst($key);
      // Check if method exists
      if (method_exists($this, $method)){
        // Executre method with value from data
        $this->$method($value);
        $methodCalled++;
      }
    }
    // Check if array if empty or not
    if ($methodCalled === 0){
      return false;
    } // Else
    return true;
  }

  public function __construct(array $data) {
    $this->hydrate($data);
  }

  // Getters
  public function id() {
    return $this->_id;
  }
  public function name() {
    return $this->_name;
  }
  public function damages() {
    return $this->_damages;
  }

  // Setters
  public function setId(int $id) {
    if (is_numeric($id) && $id > 0){ $this->_id = $id; }
  }
  public function setName(string $name) {
    if (is_string($name)){ $this->_name = $name; }
  }
  public function setDamages(int $damages) {
    if (is_numeric($damages) && $damages >= 0 && $damages <= 100){ $this->_damages = $damages; }
  }
} ?>
