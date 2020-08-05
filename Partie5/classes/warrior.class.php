<?php
class Warrior extends User {
  protected $block_chance;

  public function __construct(array $array){
    PARENT::__construct($array);
    $this->setBlock_chance($this->special);
  }

  public function takeDamage(float $strength) {
    if (rand(0,100) <= ($this->block_chance * 3 + 20)){
      // Blocked
    }
    // Add the strength of the blow to own user damages
    $this->damages += $strength;
    // If its damages are 100 or higher, return that the user is killed
    if ($this->damages >= 100){ return self::USER_KILLED; }
    // Else, return that the user is hit
    return self::USER_HIT;
  }

  // Getter
  public function block_chance(){ return $this->block_chance; }

  // Setter
  public function setBlock_chance(string $block_chance){
    if (empty(trim($block_chance)) || ! is_string($block_chance)){ return false; }
    $this->block_chance = trim($block_chance); return true;
  }
} ?>
