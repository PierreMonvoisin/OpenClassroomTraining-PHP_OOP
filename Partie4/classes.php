<?php
// Abstract means no instanciation ( "new User" ) is possible
abstract class User {
  protected $id = 3;
  private $_name = 'Pierre';
  // Getter
  public function name(){ return $this->_name; }
  public function id(){ return $this->id; }
}

class Players extends User {
  private $_username = 'Cailloux';
  // Getter
  public function username(){ return $this->_username; }
}

// Final means that this class can't have any daughter
final class SinglePlayer extends Players {
  private $_score = 50;
  // Protected is as if we redifined $id = 3 here
  // Getters on three different level
  public function score(){ return $this->_score; }
  public function username(){ return Parent::username(); }
  public function name(){ return Parent::name(); }
  // No need for getter if attribut is protected instead of private
  public function protectedId(){ return $this->id; }
} ?>
