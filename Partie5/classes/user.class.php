<?php
abstract class User {
  // Attributes / Properties
  protected $id, $name, $damages, $asleep_for, $type;
  protected $isAsleep = false;
  private $_special;

  const FRIENDLY_FIRE = 1;
  const USER_HIT = 2;
  const USER_KILLED = 3;

  const WITH_SPELL = 100;
  const AND_ASLEEP = 200;
  const BLOCKED_HIT = 300;

  // Methods
  public function hit(User $userToHit,int $strength,string $hitType) {
    // If the personne to hit and the person hitting have the same 'id', return "Friendly fire" const
    if ($this->id == $userToHit->id()){ return [self::FRIENDLY_FIRE]; }
    // Else, return to the user that it needs to take damage
    return $userToHit->takeDamage(floatval($strength));
  }

  public function takeDamage(float $strength) {
    // Add the strength of the blow to own user damages
    $this->damages += $strength;
    // If its damages are 100 or higher, return that the user is killed
    if ($this->damages >= 100){ return [self::USER_KILLED]; }
    // Else, return that the user is hit
    return [self::USER_HIT];
  }

  public function fallAsleep(int $time) {
    if ($time > 0 && $time <= 12){
      $awakeTime = strtotime('+' .round($time). ' hours');
      $this->setAsleep_for(intval($awakeTime)); $this->isAsleep = true;
    }
    return $this->isAsleep;
  }

  public function isAsleep(){
    if ($this->asleep_for === 0){
      $this->isAsleep = false;
      return $this->isAsleep;
    }
    if ($this->asleep_for < time()){
      $this->setAsleep_for(0);
      $this->isAsleep = false;
      if (get_class($this) !== 'Waiting'){
        if (! isset($manager)){ $manager = new Dbmanager; }
        $manager->updateUser($this);
      }
    }
    else {
      $this->isAsleep = true;
    }
    return $this->isAsleep;
  }

  public function displayRevivalDate(){
    if (! $this->isAsleep()){ return 'User fully awake'; }
    $revivalDate = date('d - m - Y', $this->asleep_for);
    $revivalTime = date('H:i:s', $this->asleep_for);
    return ['date'=>$revivalDate,'time'=>$revivalTime];
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

  public function __construct(array $data) {
    $this->hydrate($data);
    $this->isAsleep();
  }

  // Getters
  public function id(){ return $this->id; }
  public function name(){ return $this->name; }
  public function damages(){ return $this->damages; }
  public function asleep_for(){ return $this->asleep_for; }
  public function type(){ return $this->type; }
  public function special(){ return $this->_special; }

  // Setters
  public function setId(int $id){
    if (is_NaN($id) || $id < 0){ return false; }
    $this->id = intval($id); return true;
  }
  public function setName(string $name){
    if (empty(trim($name)) || ! is_string($name)){ return false; }
    $this->name = trim($name); return true;
  }
  public function setDamages(int $damages){
    if (is_NaN($damages) || $damages < 0 || $damages > 100){ return false; }
    $this->damages = intval($damages); return true;
  }
  public function setAsleep_for(int $asleep_for){
    if (is_NaN($asleep_for) || $asleep_for < 0){ return false; }
    $this->asleep_for = intval($asleep_for); return true;
  }
  public function setType(string $type){
    if (empty(trim($type)) || ! is_string($type)){ return false; }
    $this->type = trim($type); return true;
  }
  public function setSpecial(int $special){
    if (is_NaN($special) || $special < 0 || $special > 10){ return false; }
    $this->_special = intval($special); return true;
  }
} ?>
