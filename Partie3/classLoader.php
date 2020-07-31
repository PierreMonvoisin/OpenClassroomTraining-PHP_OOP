<?php
function loadClass($className) {
  if (! is_string($className)){
    // If the class name is not a string, alert the developper
    trigger_error('The class name must be composed a string', E_USER_WARNING); return;
  }
  else {
    // Set the name to all lowercase
    $className = strtolower(trim($className));
    // Call the class file
    require $className. '.php';
  }
}
// Add to autoload queue to be called as soon as an error for an unknown class is thrown
spl_autoload_register('loadClass'); ?>
