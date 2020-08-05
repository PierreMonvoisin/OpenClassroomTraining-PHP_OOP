<?php
class Wizard extends User {
  protected $spell;

  public function __construct(array $array){
    PARENT::__construct($array);
    $this->setSpell($this->special);
  }

  public function hit(User $userToHit,int $strength,string $hitType) {
    $sleepFor = null;
    // If the personne to hit and the person hitting have the same 'id', return "Friendly fire" const
    if ($this->id == $userToHit->id()){ return self::FRIENDLY_FIRE; }
    // Check the hit type
    if ($hitType === 'spell'){
      $strength -= round(sqrt($this->spell), 1);
      if (rand(0,100) <= ($this->spell * 1.5 + 10)){
        $sleepFor = $this->spell;
      }
      // Check if asleep
    }
    $hitStatus = $userToHit->takeDamage(floatval($strength));
    if ($hitStatus === 2){
      if ($hitType === 'spell'){ return self::USER_KILLED_WITH_SPELL; }
      return self::USER_KILLED;
    }
    if ($hitStatus >= 3){
      if ($sleepFor && $userToHit->fallAsleep($sleepFor, time())){ return self::USER_HIT_AND_ASLEEP; }
      if ($hitType === 'spell'){ return self::USER_HIT_WITH_SPELL; }
      return self::USER_HIT;
    }
    return false;
  }

  // Getter
  public function spell(){ return $this->spell; }

  // Setter
  public function setSpell(string $spell){
    if (empty(trim($spell)) || ! is_string($spell)){ return false; }
    $this->spell = trim($spell); return true;
  }
} ?>
