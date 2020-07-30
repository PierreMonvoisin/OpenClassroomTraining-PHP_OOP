<?php
class UserManager {
  private static $_database = null;

  public function addUser(User $user) {
    try {
      $stmt = self::$_database->prepare('INSERT INTO `user` (`name`,`strength`,`health`,`level`,`exp`) VALUES (:name, :strength, :health, :level, :exp)');
      // Bind all parameters safely
      $stmt->bindValue(':name', $user->name(), PDO::PARAM_STR);
      $stmt->bindValue(':strength', $user->strength(), PDO::PARAM_INT);
      $stmt->bindValue(':health', $user->health(), PDO::PARAM_INT);
      $stmt->bindValue(':level', $user->level(), PDO::PARAM_INT);
      $stmt->bindValue(':exp', $user->exp(), PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public function deleteUser(User $user) {
    try {
      $stmt = self::$_database->prepare('DELETE FROM `user` WHERE `id` = :id');
      // Bind the parameter safely
      $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public function updateUser(User $user) {
    try {
      $stmt = self::$_database->prepare('UPDATE `user` SET `name`=:name, `strength`=:strength, `health`=:health, `level`=:level, `exp`=:exp WHERE `id`=:id');
      // Bind all parameters safely
      $stmt->bindValue(':name', $user->name(), PDO::PARAM_STR);
      $stmt->bindValue(':strength', $user->strength(), PDO::PARAM_INT);
      $stmt->bindValue(':health', $user->health(), PDO::PARAM_INT);
      $stmt->bindValue(':level', $user->level(), PDO::PARAM_INT);
      $stmt->bindValue(':exp', $user->exp(), PDO::PARAM_INT);
      $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public function getUser(User $user) {
    try {
      // Declare request with paramaters
      $stmt = self::$_database->prepare('SELECT `id`,`name`,`strength`,`health`,`level`,`exp` FROM `user` WHERE `id`=:id');
      // Bind the parameter safely
      $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);
      // If the execute() return true, fetch all informations in associative array
      if ($stmt->execute()){
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data === false){
          trigger_error('Database_Error : User not found', E_USER_WARNING);
          return false;
        }
        foreach ($data as $key => $value) {
          // Make sure numbers are of the type Number
          if (is_numeric($value)) { $data[$key] = intval($value); }
        }
        return $data;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public function userList() {
    try {
      // Declare request with paramaters
      $stmt = self::$_database->prepare('SELECT `id`,`name`,`strength`,`health`,`level`,`exp` FROM `user`');
      // If the execute() return true, fetch all informations in associative array
      if ($stmt->execute()){
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $dataKey => $user){
          foreach ($user as $key => $value) {
            // Make sure numbers are of the type Number
            if (is_numeric($value)) { $user[$key] = intval($value); }
          }
          $data[$dataKey] = $user;
        }
        return $data;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // Constructor
  public function __construct() {
    if (self::$_database === null){
      require_once 'database.php';
      $this->setDatabase($database);
    }
  }

  // Setter
  public function setDatabase(PDO $db) {
    self::$_database = $db;
  }

  // Getter
  public function database(){
    return self::$_database;
  }

} ?>
