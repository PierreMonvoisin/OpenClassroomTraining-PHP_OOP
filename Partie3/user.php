<?php
class User {
  private $_id;
  private $_name;
  private $_damages;

  const FRIENDLY_FIRE = 1;
  const USER_KILLED = 2;
  const USER_HIT = 3;

  public function hit(User $userToHit) {
    // If the personne to hit and the person hitting have the same 'id', return "Friendly fire" const
    if ($this->_id == $userToHit->id()){ return self::FRIENDLY_FIRE; }
    // Else, return to the user that it needs to take damage
    return $userToHit->takeDamage();
  }

  public function takeDamage() {
    // Add 5 to own user damages
    $this->_damages += 5;
    // If its damages are 100 or higher, return that the user is killed
    if ($this->_damages >= 100){ return self::USER_KILLED; }
    // Else, return that the user is hit
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
    // Check if array if empty
    if ($methodCalled === 0){ return false; }
    // Else
    return true;
  }

  // Constructor to hydrate the users attributes
  public function __construct(array $data) { $this->hydrate($data); }

  // Getters
  public function id() { return $this->_id; }
  public function name() { return $this->_name; }
  public function damages() { return $this->_damages; }

  // Setters ( check all types before injecting values )
  public function setId(int $id) { if (is_numeric($id) && $id > 0){ $this->_id = $id; } }
  public function setName(string $name) { if (is_string($name)){ $this->_name = $name; } }
  public function setDamages(int $damages) { if (is_numeric($damages) && $damages >= 0 && $damages <= 100){ $this->_damages = $damages; } }
} ?>
