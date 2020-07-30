<?php
// Uppercase at the beginning of class ( PEAR notation )
class Personnage {
  // Underscore because private attributes ( PEAR notation )
  private $_force = 100;
  private $_experience = 0;
  private $_damage = 0;

  // Constant declaration
  const USELESS = 0;
  const WEAK = 25;
  const MEDIUM = 50;
  const STRONG = 75;
  const LEGENDARY = 100;
  // self:: to access the class, $this-> to access the object
  const FORCE_ARRAY = [self::USELESS, self::WEAK, self::MEDIUM, self::STRONG, self::LEGENDARY];

  // Static private variable
  private static $_textToSay = 'Static function working brother !';

  // Constructer
  public function __construct($force, $exp) {
    $this->setForce($force);
    $this->setExperience($exp);
    $this->setDamage(0);
  }

  // Getters
  public function force() {
    return $this->_force;
  }
  public function experience() {
    return $this->_experience;
  }
  public function damage() {
    return $this->_damage;
  }

  //Setters
  public function setForce($force) {
    if (in_array($force, self::FORCE_ARRAY)){
      $this->_force = $force;
    } else {
      trigger_error('Force must be 0, 25, 50, 75, 100', E_USER_WARNING);
    }
  }
  public function setExperience($exp) {
    if (! is_int($exp)){
      trigger_error('Experience must be a whole number', E_USER_WARNING);
      return;
    }
    if ($exp < 0 || $exp > 10000){
      trigger_error('Experience must be between 0 and 10 000', E_USER_WARNING);
      return;
    }
    $this->_experience = $exp;
  }
  public function setDamage($dmg) {
    if (! is_int($dmg)){
      trigger_error('Damage must be a whole number', E_USER_WARNING);
      return;
    }
    if ($dmg < 0 || $dmg > 5000){
      trigger_error('Damage must be between 0 and 5 000', E_USER_WARNING);
      return;
    }
    $this->_damage = $dmg;
  }

  // Specified that we must have a class as parametre
  public function hit(Personnage $personHit) {
    $personHit->_damage += $this->_force + ($this->_experience / 50);
    echo 'Person hit damage is ' .$personHit->_damage. '<br>';
    $this->gainExperience();
  }

  public function gainExperience() {
    echo 'Experience gain from ' .$this->_experience. '<br>';
    $this->_experience += 10;
    echo 'to ' .$this->_experience. '<br>';
  }

  // Static function can be accessed without an instance of the class
  public static function speak() {
    echo self::$_textToSay;
  }
}?>
