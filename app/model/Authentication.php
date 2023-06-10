<?php
namespace app\model;


class Authentication {

  private Database $database ;
	 function __construct() {
    $this->database = new Database() ;
	}

	public function register(string $user, string $pass) : bool {
    $user = strtolower($user) ;
    $result = $this->database->fetchFromDatabase(
      "SELECT * FROM csc350.users"
    ) ;
    foreach ($result as $row) {
      if ($row['username'] == $user) {
        return false;
      }
    }
    $preparedValues = [$user, $pass] ;
    $result = $this->database->queryDatabase(
      "INSERT INTO csc350.users (username, password)
              VALUES (?, ?)" , $preparedValues
    );
    if($result) {
      return true;
    } else {
      return false ;
    }
	}

	public function login(string $user, string $pass) : bool {
    $user = strtolower($user) ;
    $result = $this->database->fetchFromDatabase(
      "SELECT * FROM csc350.users"
    ) ;
    foreach ($result as $row) {
      $userid = $row['username'] ;
      $hashedPass = $row['password'] ;
      if (($user == $userid) && password_verify($pass, $hashedPass)) {
        return true ;
      }
    }
    return false ;
	}
  function getCustomerId(string $username): ?string {
    $username = strtolower($username);
    $result = $this->database->fetchFromDatabase(
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
  function getUsername(int $customerId) : ?string {
    $result = $this->database->fetchFromDatabase(
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
  function getPassword(int $customerId) : ?string {
    $result = $this->database->fetchFromDatabase(
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
  public function setCustomerKeys(int $customerId, string $keyCK, string $iVCK) : void {
     $this->database->queryDatabase(
       "INSERT INTO csc350.customerKeys (customerId, encryptionKeyCK , ivCK) 
                 VALUE (?, ?, ?)", [$customerId, $keyCK, $iVCK]
     ) ;
  }
  public function getCustomerKeys(int $customerId) : ?array{
     $result = $this->database->fetchFromDatabase(
       "SELECT encryptionKeyCK , ivCK FROM csc350.customerKeys WHERE customerId = ? ",
       [$customerId]
     ) ;
     if(!empty($result)) {
       return $result ;
     } else {
       return null ;
     }
  }
  public function getRememberMeCred(int $customerId, string $series) : ?array {
    $result = $this->database->fetchFromDatabase(
      "SELECT customerId, series, token FROM csc350.remembermesessions WHERE customerId = ? AND series = ?" ,
      [$customerId, $series]
    );

    if(!empty($result)) {
      return $result ;
    }
    return null ;
  }
  public function insertRememberMe(int $customerId, string $series, string $token) : void {
    $this->database->queryDatabase(
      "INSERT INTO csc350.rememberMeSessions (customerId, series, token)
               VALUE(?, ? , ?)" ,
      [$customerId, $series, $token]
    ) ;
  }
  public function insertNewTokenRemMe(int $customerId, string $series, string $token) : void {
    $this->database->queryDatabase(
      "UPDATE csc350.rememberMeSessions SET token = ? WHERE customerId = ? AND series = ?" ,
      [$token, $customerId, $series]
    ) ;
  }
  public function removeRememberMe(int $customerId, string $series) : void {
    $this->database->queryDatabase(
      "DELETE FROM csc350.remembermesessions WHERE customerId = ? AND series = ?" ,
      [$customerId, $series]
    ) ;
  }
  public function removeAllRememberMe(int $customerId) : void {
     $this->database->queryDatabase(
       "DELETE FROM csc350.remembermesessions WHERE customerId = ?"  ,
       [$customerId]
     ) ;
  }
  public function removeAllEncryptionKeys() {

  }


}

