<?php
class Warrior extends User {
  protected $block_chance;

  public function __construct(array $array){
    PARENT::__construct($array);
  }

  public function takeDamage(float $strength) {
    $hitBlocked = false;
    if (rand(0,100) <= ($this->block_chance * 3 + 20)){
      // Blocked
      $strength = round(($strength / 3), 1);
      $hitBlocked = true;
    }
    // Add the strength of the blow to own user damages
    $this->damages += $strength;
    // If its damages are 100 or higher, return that the user is killed
    if ($this->damages >= 100){ return [self::USER_KILLED]; }
    // Else, return that the user is hit
    if ($hitBlocked){ return [self::USER_HIT, self::BLOCKED_HIT]; }
    return [self::USER_HIT];
  }

  // Getter
  public function block_chance(){ return $this->block_chance; }
  public function special(){ return $this->block_chance; }

  // Setter
  public function setSpecial(int $special){
    if (is_NaN($special) || $special < 0 || $special > 10){ return false; }
    $this->block_chance = intval($special); return true;
  }
} ?>
