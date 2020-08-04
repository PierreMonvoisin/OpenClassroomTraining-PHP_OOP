<?php
final class Dbmanager {
  // Declare private variable
  private static $_database = null;

  // Add user to the database
  public function addUser(User $user) {
    try {
      // Prepare statement with 'name' and 'damages' as parameters
      $stmt = self::$_database->prepare('INSERT INTO `user` (`name`,`damages`,`asleep_for`,`type`,`special`) VALUES (:name, :damages, :asleep_for, :type, :special)');
      // Bind all parameters safely
      $stmt->bindValue(':name', $user->name(), PDO::PARAM_STR);
      $stmt->bindValue(':damages', $user->damages() ?: 0, PDO::PARAM_INT);
      $stmt->bindValue(':asleep_for', $user->asleep_for() ?: 0, PDO::PARAM_INT);
      $stmt->bindValue(':type', $user->type(), PDO::PARAM_STR);
      $stmt->bindValue(':special', $user->special() ?: null, PDO::PARAM_STR);
      // Return the execute() return value
      return $stmt->execute();
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Delete user from database
  public function deleteUser(User $user) {
    try {
      // Prepare statement only with user 'id'
      $stmt = self::$_database->prepare('DELETE FROM `user` WHERE `id` = :id');
      // Bind the parameter safely
      $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      // Return the execute() return value
      return $stmt->execute();
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Update user infos in the database
  public function updateUser(User $user) {
    try {
      // Prepare statement to update 'name' and 'damages' at the specified 'id'
      $stmt = self::$_database->prepare('UPDATE `user` SET `name`=:name, `damages`=:damages, `asleep_for`=:asleep_for, `type`=:type, `special`=:special WHERE `id`=:id');
      // Bind all parameters safely
      $stmt->bindValue(':name', $user->name(), PDO::PARAM_STR);
      $stmt->bindValue(':damages', $user->damages() ?: 0, PDO::PARAM_INT);
      $stmt->bindValue(':asleep_for', $user->asleep_for() ?: 0, PDO::PARAM_INT);
      $stmt->bindValue(':type', $user->type(), PDO::PARAM_STR);
      $stmt->bindValue(':special', $user->special(), PDO::PARAM_STR);
      $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      // Return the execute() return value
      return $stmt->execute();
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Get the informations of the single user from the database
  public function getUser(User $user) {
    try {
      // Check if the id of the user is set
      if ($user->id() !== null){
        // Prepare statement to search the user from its id
        $stmt = self::$_database->prepare('SELECT `id`,`name`,`damages`,`asleep_for`,`type`,`special` FROM `user` WHERE `id`=:id');
        // Bind the parameter safely
        $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      }
      else if ($user->name() !== null){
        // Prepare statement to search the user from its name
        $stmt = self::$_database->prepare('SELECT `id`,`name`,`damages`,`asleep_for`,`type`,`special` FROM `user` WHERE `name`=:name');
        // Bind the parameter safely
        $stmt->bindValue(':name', $user->name(), PDO::PARAM_STR);
      }
      // If the execute() return true, fetch all informations in associative array
      if ($stmt->execute()){
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // If the data was found
        if ($data !== false){
          foreach ($data as $key => $value) {
            // Make sure numbers are of the type Number
            if (is_numeric($value)) { $data[$key] = intval($value); }
          }
        }
        return $data;
      } else { return false; }
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Get the informations of all user in the database
  public function userList() {
    try {
      // Prepare statement to search for all infos of all users
      $stmt = self::$_database->prepare('SELECT `id`,`name`,`damages`,`asleep_for`,`type`,`special` FROM `user`');
      // If the execute() return true, fetch all informations in associative array
      if ($stmt->execute()){
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // If the data was found
        if ($data !== false){
          foreach ($data as $dataKey => $user){
            foreach ($user as $key => $value) {
              // Make sure numbers are of the type Number
              if (is_numeric($value)) { $user[$key] = intval($value); }
            }
            $data[$dataKey] = $user;
          }
        }
        return $data;
      } else { return false; }
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Count the number of users in the database
  public function countUsers() {
    try {
      // Declare request with paramaters
      $stmt = self::$_database->prepare('SELECT `id` FROM `user`');
      // If the execute() return true, fetch all users in associative array
      if ($stmt->execute()){
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // If the data wasn't found, return false
        if (! $data){ return false; }
        // Return the number of user in the array
        return count($data);
      } else { return false; }
    } catch (PDOException $e) { return $e->getMessage(); }
  }

  // Constructor
  public function __construct() {
    // If the static var "database" is null, setup a new connection to the database
    if (self::$_database === null){
      require_once 'model/database.php';
      $this->setDatabase($database);
    }
  }

  // Getter
  public function database(){ return self::$_database; }

  // Setter ( check type PDO before injecting value )
  public function setDatabase(PDO $db) { self::$_database = $db; }
} ?>
