<?php

namespace app\model ;

use mysqli;
class Database {
  private string $servername, $username, $password, $databaseName ;

  public function __construct() {
    $this->servername = 'localhost' ;
    $this->username = 'root' ;
    $this->password = ''  ;
    $this->databaseName = 'csc350' ;
  }

  private function connectToDatabase($noDatabaseName = false) : mysqli {
    if($noDatabaseName) {
      $conn = new mysqli($this->servername, $this->username, $this->password) ;
      if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error) ;
      }else {
        return $conn ;
      }
    } else {
      $conn = new mysqli($this->servername, $this->username, $this->password, $this->databaseName) ;
      if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error) ;
      }
      return $conn ;
    }
  }
  private function disconnectFromDatabase(mysqli $conn): void {
    $conn->close();
  }
  public function createDatabase($sqlScript, $routeTo = 'index.php?choice=login'): void {
    $conn = $this->connectToDatabase(true);

    $checkDatabaseQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA 
                               WHERE SCHEMA_NAME = '$this->databaseName'";
    $checkResult = $conn->query($checkDatabaseQuery);
    if ($checkResult->num_rows == 0) {
      $scriptPath = __DIR__ . $sqlScript;
      $script = file_get_contents($scriptPath);
      if ($conn->multi_query($script)) {
        $this->disconnectFromDatabase($conn);
        ob_start();
        header("Location: $routeTo");
        ob_end_flush();
        exit();
      } else {
        echo 'Error executing script: ' . $conn->error;
      }
    } else {
      $this->disconnectFromDatabase($conn);
    }
  }
  public function queryDatabase($sqlQuery) : bool {
    $conn = $this->connectToDatabase() ;
    if(true) {
      return true ;
    } else {
      return false ;
    }
  }
  public function multiQueryDatabase(...$sqlQueries) : bool {
    $conn = $this->connectToDatabase() ;
    foreach ($sqlQueries as $sqlQuery) {

    }
    if(true) { //if query went through return true else return false
      return true ;
    }else {
      return false ;
    }
  }
  public function fetchFromDatabase($sqlQuery) : array {
    $arr = [true] ;
    $conn = $this->connectToDatabase() ;

    return $arr ;
  }





}
