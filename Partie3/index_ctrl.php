<?php include 'classLoader.php';
$manager = new UserManager;

// Forms
$error = false; $errorMessage = '_ERROR_';
$valid = false; $validMessage = '_ERROR_';
$username = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['username']) && ! empty(trim($_POST['username']))){
    $username = trim($_POST['username']);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    // Create the options array with the reg ex for the username
    $usernameOptions = ['options'=>['regexp'=>'/^(?=.*[a-z])[a-zA-Z "\'-]{4,150}$/']];
    if (! filter_var($username, FILTER_VALIDATE_REGEXP, $usernameOptions)){
      $errorMessage = 'Username is incorrect, try with another one !<br><h5 class="text-center text-danger">Only valid character are letters (no accents), " , \' and - between 4 and 150 characters.<h5>'; $error = true;
      return;
    }
  }
  else {
    $errorMessage = 'Username input must be filled !'; $error = true;
    return;
  }
  // Check which button the user pressed
  if (isset($_POST['create'])){
    $user = new User(['name'=>$username]);
    if ($manager->userExists($user)){
      $errorMessage = 'Name already taken !'; $error = true;
      return;
    }
    if (! $manager->addUser($user)){
      $errorMessage = 'Name already taken !'; $error = true;
      return;
    }
    $validMessage = 'Account registered ! Please <u>connect</u> to continue.'; $valid = true;
    // return;
  }
} ?>
