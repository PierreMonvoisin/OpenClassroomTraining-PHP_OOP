<?php
class Wizard extends User {
  protected $special;

  public function id(){ return $this->id; }
  public function name(){ return $this->name; }
  public function damages(){ return $this->damages; }
  public function asleep_for(){ return $this->asleep_for; }
  public function type(){ return $this->type; }
  
  // Getter
  public function special(){ return $this->special; }

  // Setter
  public function setSpecial(string $special){
    if (empty(trim($special)) || ! is_string($special)){ return false; }
    $this->special = trim($special); return true;
  }
} ?>
