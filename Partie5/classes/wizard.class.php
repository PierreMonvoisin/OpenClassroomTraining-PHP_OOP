<?php
class Wizard extends User {
  protected $spell;

  public function __construct(array $array){
    PARENT::__construct($array);
  }

  public function hit(User $userToHit,int $strength,string $hitType) {
    $sleepFor = null;
    // If the personne to hit and the person hitting have the same 'id', return "Friendly fire" const
    if ($this->id == $userToHit->id()){ return [self::FRIENDLY_FIRE]; }
    // Check the hit type
    if ($hitType === 'spell'){
      $strength -= round(sqrt($this->spell), 1);
      if (rand(0,100) <= ($this->spell * 1.5 + 10)){
        $sleepFor = $this->spell;
      }
    }
    // Check if asleep
    $hitStatus = $userToHit->takeDamage(floatval($strength));
    if ($hitStatus[0] === self::USER_KILLED){
      if ($hitType === 'spell'){ return [self::USER_KILLED, self::WITH_SPELL]; }
      return $hitStatus;
    }
    if ($hitStatus[0] === self::USER_HIT){
      if ($sleepFor && $userToHit->fallAsleep(floatval($sleepFor))){ return [self::USER_HIT, self::AND_ASLEEP]; }
      if ($hitType === 'spell' && count($hitStatus) === 1){ return [self::USER_HIT, self::WITH_SPELL]; }
      return $hitStatus;
    }
    return false;
  }

  // Getter
  public function spell(){ return $this->spell; }
  public function special(){ return $this->spell; }

  // Setter
  public function setSpecial(int $special){
    if (is_NaN($special) || $special < 0 || $special > 10){ return false; }
    $this->spell = intval($special); return true;
  }
} ?>
