<?php include 'classLoader.php';
$manager = new UserManager;
if (session_status() == PHP_SESSION_NONE){
  session_start();
}
// Forms
$error = false; $errorMessage = '_ERROR_';
$valid = false; $validMessage = '_ERROR_';
$username = null; $userConnected = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['disconnect'])){
    session_destroy();
    header('Location: /Partie3/index.php');
    exit();
  }
  if (isset($_POST['hitPlayer'])){
    if (isset($_SESSION['userConnected']) && ! empty($_SESSION['userConnected'])){
      $user = $_SESSION['userConnected'];
      if (isset($_POST['userToHitId']) && ! empty(trim($_POST['userToHitId']))){
        $userToHitId = trim($_POST['userToHitId']);
        $userToHit = new User(['id'=>$userToHitId]);
        if ($userToHitId > 0 && $manager->userExists($userToHit)){
          $userToHitData = $manager->getUser($userToHit);
          if ($userToHit->hydrate($userToHitData)){
            $combatStatus = $user->hit($userToHit);
            if ($combatStatus > 1){
             if ($combatStatus === 3 && $manager->updateUser($userToHit)){
               $validMessage = 'User hit for 5 damages, well done !'; $valid = true; return;
             }
             else if ($combatStatus === 2 && $manager->deleteUser($userToHit)){
               $validMessage = 'User hit and killed, congratulations on another slaughter !'; $valid = true; return;
             }
             else { $errorMessage = 'An error occured, please logout and login again.'; $error = true; return; }
            } else { $errorMessage = 'You cannot hit yourself !'; $error = true; return; }
          }
          else { $errorMessage = 'User to hit to found, please reaload and try again.'; $error = true; return; }
        }
        else { $errorMessage = 'User to hit to found, please reaload and try again.'; $error = true; return; }
      }
      else { $errorMessage = 'An error occured, please logout and login again.'; $error = true; return; }
    }
    else { $errorMessage = 'You must be connected to hit a player'; $error = true; return; }
  }
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
  $user = new User(['name'=>$username]);
  // Check which button the user pressed
  if (isset($_POST['create'])){
    if ($manager->userExists($user)){
      $errorMessage = 'Name already taken !'; $error = true;
      return;
    }
    if (! $manager->addUser($user)){
      $errorMessage = 'Error with the database, please retry later'; $error = true;
      return;
    }
    $validMessage = 'Account registered ! Please <u>connect</u> to continue.'; $valid = true;
    return;
  }
  if (isset($_POST['use'])){
    if (! $manager->userExists($user)){
      $errorMessage = 'Username unknown, please retry or create an account.'; $error = true;
      return;
    }
    $userData = $manager->getUser($user);
    if (! $userData){
      $errorMessage = 'Error with the database, please retry later'; $error = true;
      return;
    }
    if ($user->hydrate($userData)){
      $validMessage = 'You are connected, nice to see you !'; $valid = true;
      $_SESSION['userConnected'] = $user;
      $userConnected = true;
    }
  }
} ?>
