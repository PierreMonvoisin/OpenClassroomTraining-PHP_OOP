<?php
define('USER', 'pierremonvoisin');
define('PASSWORD', 'f0O91n5QftTYTCj');
define('HOST', 'localhost');
define('DB', 'OC-P5');
// Set database state to null onload
$database = null;
try {
  // Create new PDO object as the connection to the database
  $database = new PDO('mysql:dbname=' .DB. ';host=' .HOST. ';charset=utf8', USER, PASSWORD, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
  // If there is a problem, die everything and display the mail to contact the admin
  die('Charlie ! We lost connection ! Mayday at code [ ' .$e->getCode(). ' ]. Please send help from sysadmin !');
} ?>
