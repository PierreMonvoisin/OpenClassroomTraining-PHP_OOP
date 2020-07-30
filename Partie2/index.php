<?php include 'classLoader.php';
$user = new User;
$user->hydrate(['name'=>'Victor', 'strength'=>5, 'health'=>100, 'level'=>1, 'exp'=>10]);
$manager = new UserManager;
$manager->addUser($user);
?>
