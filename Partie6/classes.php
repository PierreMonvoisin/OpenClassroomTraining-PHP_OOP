<?php
class Tableau implements SeekableIterator, ArrayAccess, Countable {
  private $previousPosition = 0;
  private $position = 0;
  private $tableau = ['zero', 'un', 'deux', 'trois', 'quatre', 'cinq'];

  // SeekableIterator
  public function current(){
    return $this->tableau[$this->position];
  }
  public function key(){
    return $this->position;
  }
  public function next(){
    $this->position++;
  }
  public function rewind(){
    $this->position = 0;
  }
  public function valid(){
    return (isset($this->tableau[$this->position]) && ! empty($this->tableau[$this->position]));
  }
  public function seek($position){
    if (is_int($position) && $position > 0){
      $this->previousPosition = $this->position;
      $this->position = $position;
      if (!$this->valid()){
        trigger_error('La position spécifiée n\'est pas valide', E_USER_WARNING);
        $this->position = $this->previousPosition;
        return false;
      }
    }
    else { trigger_error('La position spécifiée n\'est pas valide', E_USER_WARNING); return false; }
    return $this->current();
  }
  // ArrayAccess
  public function offsetExists($key){
    return (isset($this->tableau[$key]) && ! empty($this->tableau[$key]));
  }
  public function offsetGet($key){
    return $this->tableau[$key];
  }
  public function offsetSet($key, $value){
    $this->tableau[$key] = $value;
  }
  public function offsetUnset($key){
    unset($this->tableau[$key]);
  }
  // Countable
  public function count(){
    return count($this->tableau);
  }
} ?>
