<?php
class staticTest {
  // Declare a static variable to count how many times the class is called
  private static $_timeCalled = 0;

  public function __construct() {
    // Increment the variable in the constucter
    self::$_timeCalled++;
  }

  // Simple static function to display how many times the class was called
  public static function howManyTimes() {
    echo self::$_timeCalled;
  }
} ?>
