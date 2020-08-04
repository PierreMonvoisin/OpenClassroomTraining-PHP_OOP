<?php include 'classes.php';
echo 'Score for ' .(new SinglePlayer)->name(). ', also known as ' .(new SinglePlayer)->username(). ' is of ' .(new SinglePlayer)->score(). ' points !<br>';
echo 'The ID is protected, not private, so you can just display it, no need for getters : ' .(new SinglePlayer)->protectedId(). '<br>';
echo 'This a test to call on a parent function form a child without rewriting : ' .(new SinglePlayer)->id(); 
?>
