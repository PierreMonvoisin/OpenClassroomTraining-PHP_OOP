<?php
function autoloadClass($className) {
  if (! is_string($className)){ return false; }
  // Set the name to all lowercase
  $className = strtolower(trim($className));
  // Check if file can be found
  $filePath = 'classes/' .$className. '.class.php';
  $alternateFilePath = 'model/' .$className. '.class.php';
  // If the file exist in the class directory, require it there
  if (file_exists($filePath)){ require_once $filePath; return true; }
  // Else, search in the model directory
  if (file_exists($alternateFilePath)){ require_once $alternateFilePath; return true; }
  return false;
}
// Add to autoload queue to be called as soon as an error for an unknown class is thrown
spl_autoload_register('autoloadClass'); ?>
