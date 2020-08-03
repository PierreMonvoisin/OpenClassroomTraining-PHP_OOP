<?php include 'share/classLoader.php';
$manager = new Dbmanager;
if (session_status() == PHP_SESSION_NONE){
  session_start();
}
// Forms
$error = false; $errorMessage = '_ERROR_';
$valid = false; $validMessage = '_ERROR_';
$username = null; $type = null;
$typeArray = ['warrior', 'wizard'];
$userConnected = false;

// At each post form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // If the user wants to disconnect
  if (isset($_POST['disconnect'])){
    // Destroy the session and bring it to the home page
    session_destroy();
    header('Location: /Partie5/');
    exit();
  }
  // If the user wants to hit another player
  if (isset($_POST['hitPlayer'])){
    // Check if the user is connected
    if (isset($_SESSION['userConnected']) && ! empty($_SESSION['userConnected'])){
      $user = $_SESSION['userConnected'];
      // Get the id of the user to hit
      if (isset($_POST['userToHitId']) && ! empty(trim($_POST['userToHitId']))){
        $userToHitId = trim($_POST['userToHitId']);
        $userToHit = new Waiting(['id'=>$userToHitId]);
        // Check if user exist
        if ($userToHitId > 0 && $manager->getUser($userToHit)){
          // Get all its informations
          $userToHitData = $manager->getUser($userToHit);
          if ($userToHit->hydrate($userToHitData)){
            // Actually hit the other user
            $combatStatus = $user->hit($userToHit, 5);
            if ($combatStatus > 1){
              // If strike went well
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
  // If user filled the username input field
  if (isset($_POST['username']) && ! empty(trim($_POST['username']))){
    // Get the username, sanitize and validate it
    $username = trim($_POST['username']);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    // Create the options array with the reg ex for the username
    $usernameOptions = ['options'=>['regexp'=>'/^(?=.*[a-z])[a-zA-Z "\'-]{4,150}$/']];
    if (! filter_var($username, FILTER_VALIDATE_REGEXP, $usernameOptions)){
      $errorMessage = 'Username is incorrect, try with another one !<br><h5 class="text-center text-danger">Only valid character are letters (no accents), " , \' and - between 4 and 150 characters.<h5>'; $error = true;
      return;
    }
  }
  else { $errorMessage = 'Username input must be filled !'; $error = true; return; }
  // Check which button the user pressed
  if (! isset($_POST['type']) || empty(trim($_POST['type']))){
    $errorMessage = 'Select a type of character to continue !'; $error = true;
    return;
  }
  $type = strtolower(trim($_POST['type']));
  $type = filter_var($type, FILTER_SANITIZE_STRING);
  if (! in_array($type, $typeArray)){
    $errorMessage = 'Select a correct type of character to continue !'; $error = true;
    return;
  }
  $user = new Waiting(['special'=>1,'name'=>$username,'type'=>$type]);
  // User wants to create an account
  if (isset($_POST['create'])){
    // Check if user already exists
    if ($manager->getUser($user)){
      $errorMessage = 'Name already taken !'; $error = true;
      return;
    }
    // Add user to the database
    if (! $manager->addUser($user)){
      $errorMessage = 'Error with the database, please retry later'; $error = true;
      return;
    }
    $validMessage = 'Account registered ! Please <u>connect</u> to continue.'; $valid = true;
    return;
  }
  // User wants to connect to its account
  if (isset($_POST['use'])){
    // Check if user exists
    if (! $manager->getUser($user)){
      $errorMessage = 'Username unknown, please retry or create an account.'; $error = true;
      return;
    }
    // Get all the informations of the user from the database
    $userData = $manager->getUser($user);
    if (! $userData){
      $errorMessage = 'Error with the database, please retry later'; $error = true;
      return;
    }
    if ($user->hydrate($userData)){
      // If all info are found, connect the user
      $validMessage = 'You are connected, nice to see you !'; $valid = true;
      // Set its object in the session to serve as a " user connected " check
      $_SESSION['userConnected'] = $user;
      $userConnected = true;
    }
  }
} ?>
