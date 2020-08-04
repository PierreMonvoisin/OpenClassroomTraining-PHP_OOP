<?php
class Wizard extends User {
  protected $spell;

  public function __construct(array $array){
    PARENT::__construct($array);
  }
  
  // Getter
  public function spell(){ return $this->spell; }

  // Setter
  public function setSpell(string $spell){
    if (empty(trim($spell)) || ! is_string($spell)){ return false; }
    $this->spell = trim($spell); return true;
  }
} ?>
