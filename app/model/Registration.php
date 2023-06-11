<?php

namespace app\model;

use mysqli_sql_exception;

class Registration {

  private Database $database ;
  function __construct() {
    $this->database = new Database() ;
  }
  public function register(string $user, string $pass) : bool {
    try {
      $user = strtolower($user) ;
      $result = $this->database->fetchFromDatabase(
        "SELECT * FROM csc350.users"
      ) ;
      foreach ($result as $row) {
        if ($row['username'] == $user) {
          return false;
        }
      }
      $result = $this->database->queryDatabase(
        "INSERT INTO csc350.users (username, password)
              VALUES (?, ?)" , [$user, $pass]
      );
      if($result) {
        return true;
      } else {
        return false ;
      }
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }

  }
}