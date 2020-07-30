<?php
function loadClass($className) {
  if (! is_string($className)){
    trigger_error('The class name must be composed a string', E_USER_WARNING);
    return;
  }
  $className = strtolower(trim($className));
  require $className. '.php';
}
spl_autoload_register('loadClass'); ?>
