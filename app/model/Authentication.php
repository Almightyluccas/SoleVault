<?php
namespace app\model;


use mysql_xdevapi\Exception;
use mysqli_sql_exception;

class Authentication {

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
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e, true)) ;
       throw $e ;
     }

	}

	public function login(string $user, string $pass) : bool {
     $user = strtolower($user) ;
     try {
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
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e, true)) ;
       throw $e ;
     }

    return false ;
	}
  function getCustomerId(string $username): ?string {
    $username = strtolower($username);
    try {
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
        throw new Exception('Not Found') ;
      }
    } catch (mysqli_sql_exception|Exception $e) {
      error_log(var_export($e,true)) ;
      throw $e ;
    }
    return null;

   }
  function getUsername(int $customerId) : ?string {
     try {
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
         throw new Exception('Not Found') ;
       }
     } catch (mysqli_sql_exception|Exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }


    return null;
  }
  function getPassword(int $customerId) : ?string {
     try{
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
         throw new Exception('Not Found') ;
       }

    } catch (mysqli_sql_exception|Exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
    }
    return null ;
  }
  public function setCustomerKeys(int $customerId, string $keyCK, string $iVCK) : void {
     try {
       $this->database->queryDatabase(
         "INSERT INTO csc350.customerKeys (customerId, encryptionKeyCK , ivCK) 
                 VALUE (?, ?, ?)", [$customerId, $keyCK, $iVCK]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }

  }
  public function getCustomerKeys(int $customerId) : ?array{
     try {
       return $this->database->fetchFromDatabase(
         "SELECT encryptionKeyCK , ivCK FROM csc350.customerKeys WHERE customerId = ? ",
         [$customerId]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }


  }
  public function getRememberMeCred(int $customerId, string $series) : array {
     try {
       return $this->database->fetchFromDatabase(
         "SELECT customerId, series, token FROM csc350.remembermesessions WHERE customerId = ? AND series = ?" ,
         [$customerId, $series]
       );

     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }

  }
  public function insertRememberMe(int $customerId, string $series, string $token) : void {
     try {
       $this->database->queryDatabase(
         "INSERT INTO csc350.rememberMeSessions (customerId, series, token)
               VALUE(?, ? , ?)" ,
         [$customerId, $series, $token]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }
  }
  public function insertNewTokenRemMe(int $customerId, string $series, string $token) : void {
     try {
       $this->database->queryDatabase(
         "UPDATE csc350.rememberMeSessions SET token = ? WHERE customerId = ? AND series = ?" ,
         [$token, $customerId, $series]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }

  }
  public function removeRememberMe(int $customerId, string $series) : void {
     try{
       $this->database->queryDatabase(
         "DELETE FROM csc350.remembermesessions WHERE customerId = ? AND series = ?" ,
         [$customerId, $series]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }

  }
  public function removeAllRememberMe(int $customerId) : void {
     try{
       $this->database->queryDatabase(
         "DELETE FROM csc350.remembermesessions WHERE customerId = ?"  ,
         [$customerId]
       ) ;
     } catch (mysqli_sql_exception $e) {
       error_log(var_export($e,true)) ;
       throw $e ;
     }

  }



}

