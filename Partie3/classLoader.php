<?php
function autoloadClass($className) {
  if (! is_string($className)){ return false; }
  // Set the name to all lowercase
  $className = strtolower(trim($className));
  // Check if file can be found
  if (! file_exists($className. '.php')){ return false; }
  $filePath = $className. '.php';
  // Call the class file
  require_once $filePath;
}
// Add to autoload queue to be called as soon as an error for an unknown class is thrown
spl_autoload_register('autoloadClass'); ?>
