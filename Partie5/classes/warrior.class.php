<?php
class Warrior extends User {
  protected $block_chance;

  public function __construct(array $array){
    PARENT::__construct($array);
  }
  
  // Getter
  public function block_chance(){ return $this->block_chance; }

  // Setter
  public function setBlock_chance(string $block_chance){
    if (empty(trim($block_chance)) || ! is_string($block_chance)){ return false; }
    $this->block_chance = trim($block_chance); return true;
  }
} ?>
