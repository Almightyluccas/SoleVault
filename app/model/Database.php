<?php

namespace app\model ;

use mysqli;
class Database {
  private string $servername, $username, $password, $databaseName ;
  private ?string $lastError;

  public function __construct() {
    $this->servername = 'localhost' ;
    $this->username = 'root' ;
    $this->password = ''  ;
    $this->databaseName = 'csc350' ;
    $this->lastError = null ;
  }

  private function connectToDatabase() : mysqli {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->databaseName);
    if ($conn->connect_error) {
      $this->lastError = "Connection failed: " . $conn->connect_error;
      die($this->lastError);
    }
    return $conn;
  }

  public function queryDatabase(string $sqlQuery, array $values = []): bool {
    $conn = $this->connectToDatabase();
    $stmt = $conn->prepare($sqlQuery);
    if ($stmt) {
      if (!empty($values)) {
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);
      }
      if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
      } else {
        $this->lastError = "SQL Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        return false;
      }
    } else {
      $this->lastError = "SQL Error: " . $conn->error;
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
  public function fetchFromDatabase(string $sqlQuery, array $values = []): array {
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
  public function getLastErrorMessage(): ?string {
    return $this->lastError;
  }
}