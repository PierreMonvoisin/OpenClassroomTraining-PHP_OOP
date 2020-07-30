<?php
define('USER', 'pierremonvoisin');
define('PASSWORD', 'f0O91n5QftTYTCj');
define('HOST', 'localhost');
define('DB', 'OC-P3');
$database = null;
try {
  // Create new PDO object as the connection to the database
  $database = new PDO('mysql:dbname=' .DB. ';host=' .HOST. ';charset=utf8', USER, PASSWORD, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
  // If there is a problem, die everything and display the mail to contact the admin
  die('La connexion à la base de données a échoué, veuillez contacter l\'administrateur du site !<br>Connection to database failed, please contact website\'s administrator !<br>solutioncubed.contact@gmail.com<br>Error Code : '.$e->getCode());
} ?>
