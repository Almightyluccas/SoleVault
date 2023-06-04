<?php
namespace app\model;


class Login extends Database {
	public function __construct()  {
    parent::__construct() ;
	}

	public function register($user,$pass) : bool {
    $user = strtolower($user) ;
    $result = parent::fetchFromDatabase(
      "SELECT * FROM csc350.users"
    ) ;
    foreach ($result as $row) {
      if ($row['username'] == $user) {
        return false;
      }
    }
    $preparedValues = [$user, $pass] ;
    $result = parent::queryDatabase(
      "INSERT INTO csc350.users (username, password)
              VALUES (?, ?)" , $preparedValues
    );
    if($result) {
      return true;
    } else {
      return false ;
    }
	}

	public function login($user, $pass) : bool {
    $user = strtolower($user) ;
    $result = parent::fetchFromDatabase(
      "SELECT * FROM csc350.users"
    ) ;
    foreach ($result as $row) {
      $userid = $row['username'] ;
      $password = $row['password'] ;
      if (($user == $userid) && ($pass == $password)) {
        return true ;
      }
    }
    return false ;
	}
  function getCustomerId($username): ?string {
    $username = strtolower($username);
    $result = parent::fetchFromDatabase(
      "SELECT customerId FROM csc350.users WHERE username = ?",
      [$username]
    );
    if (count($result) > 0) {
      foreach ($result as $row) {
        if (!empty($row['customerId'])) {
          return $row['customerId'];
        }
      }
    } else {
      error_log("Error retrieving data from the database");
    }
    return null;
  }
  function getUsername($customerId) : ?string {
    $result = parent::fetchFromDatabase(
      "SELECT username FROM csc350.users WHERE customerId = ?" ,
      [$customerId]
    ) ;
    if (count($result) > 0) {
      foreach ($result as $row) {
        if (!empty($row['username'])) {
          return $row['username'];
        }
      }
    } else {
      error_log("Error retrieving data from the database");
    }
    return null;
  }
  function getPassword($customerId) : ?string {
    $result = parent::fetchFromDatabase(
      "SELECT password FROM csc350.users WHERE customerId = ?" ,
      [$customerId]
    ) ;
    if (count($result) > 0) {
      foreach ($result as $row) {
        if (!empty($row['username'])) {
          return $row['username'];
        }
      }
    } else {
      error_log("Error retrieving data from the database");
    }
    return null;
  }
  public function getRememberMeCred($customerId ) : ?array {
    $result = parent::fetchFromDatabase(
      "SELECT customerId, series, token FROM csc350.remembermesessions WHERE customerId = ?" ,
      [$customerId]
    );
    if(!empty($result)) {
      return $result ;
    }
    return null ;
  }
  public function insertRememberMe($customerId, $series,$token) : void {
    parent::queryDatabase(
      "INSERT INTO csc350.rememberMeSessions (customerId, series, token)
               VALUE(?, ? , ?)" ,
      [$customerId, $series, $token]
    ) ;
  }
  public function insertNewTokenRemMe($customerId, $series, $token) : void {
    parent::queryDatabase(
      "UPDATE csc350.rememberMeSessions SET token = ? WHERE customerId = ? AND series = ?" ,
      [$token, $customerId, $series]
    ) ;
  }
  public function removeRememberMe($customerId, $series) : void {
    parent::queryDatabase(
      "DELETE FROM csc350.remembermesessions WHERE customerId = ? AND series = ?" ,
      [$customerId, $series]
    ) ;
  }
}

