<?php
class Wizard extends User {
  protected $spell;

  public function __construct(array $array){
    PARENT::__construct($array);
    $this->setSpell($this->special);
  }

  public function hit(User $userToHit,int $strength,string $hitType) {
    // If the personne to hit and the person hitting have the same 'id', return "Friendly fire" const
    if ($this->id == $userToHit->id()){ return self::FRIENDLY_FIRE; }
    // Check the hit type
    if ($hitType === 'spell'){
      $strength -= round(sqrt($this->spell), 1);
      if (rand(0,100) <= ($this->spell * 1.5 + 10)){
        // Player asleep
      }
      // Check if asleep
    }
    // Else, return to the user that it needs to take damage
    return $userToHit->takeDamage(floatval($strength));
  }

  // Getter
  public function spell(){ return $this->spell; }

  // Setter
  public function setSpell(string $spell){
    if (empty(trim($spell)) || ! is_string($spell)){ return false; }
    $this->spell = trim($spell); return true;
  }
} ?>
