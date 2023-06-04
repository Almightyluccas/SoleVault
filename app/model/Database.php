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
  public function createDatabase($sqlScript, $routeTo = 'index.php?choice=login'): void {
    $conn = $this->connectToDatabase(true);

    $checkDatabaseQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA 
                               WHERE SCHEMA_NAME = '$this->databaseName'";
    $checkResult = $conn->query($checkDatabaseQuery);
    if ($checkResult->num_rows == 0) {
      $scriptPath = __DIR__ . $sqlScript;
      $script = file_get_contents($scriptPath);
      if ($conn->multi_query($script)) {
        $conn->close();
        ob_start();
        header("Location: $routeTo");
        ob_end_flush();
        exit();
      } else {
        echo 'Error executing script: ' . $conn->error;
      }
    } else {
      $conn->close();
    }
  }
  public function queryDatabase($sqlQuery, $values = []) : bool {
    $conn = $this->connectToDatabase();
    $stmt = $conn->prepare($sqlQuery);
    if ($stmt) {
      if (!empty($values)) {
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);
      }
      $stmt->execute();
      $stmt->close();
      $conn->close();
      return true;
    } else {
      $conn->close();
      return false;
    }
  }
  public function multiQueryDatabase(array $queries): bool {
    $conn = $this->connectToDatabase();
    $success = true;
    foreach ($queries as $sqlQuery => $values) {
      $stmt = $conn->prepare($sqlQuery);
      if ($stmt) {
        if (!empty($values)) {
          $stmt->bind_param(str_repeat('s', count($values)), ...$values);
        }
        $stmt->execute();
        if ($stmt->errno) {
          $success = false;
        }
        $stmt->close();
      } else {
        $success = false;
      }
    }
    $conn->close();
    return $success;
  }
  public function fetchFromDatabase($sqlQuery, $values = []): array {
    $arr = [];
    $conn = $this->connectToDatabase();

    $stmt = $conn->prepare($sqlQuery);
    if ($stmt) {
      if (!empty($values)) {
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $arr[] = $row;
        }
      }
      $stmt->close();
    }
    $conn->close();
    return $arr;
  }
}
