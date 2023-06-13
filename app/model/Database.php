<?php

namespace app\model;

use mysqli;
use mysqli_sql_exception;

class Database {
  private string $servername, $username, $password, $databaseName;

  public function __construct() {
    $config = parse_ini_file(__DIR__ . '\..\..\dbConfig.conf') ;
    $this->servername = $config['serverName'] ;
    $this->username = $config['dbUsername'] ;
    $this->password = $config['dbPassword'] ;
    $this->databaseName = $config['dbName'] ;
  }

  private function connectToDatabase(): mysqli {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->databaseName);
    if ($conn->connect_error) {
      throw new mysqli_sql_exception($conn->error);
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
          $stmt->close();
          $conn->close();
          throw new mysqli_sql_exception($conn->error);
        }
      } else {
        $conn->close();
        throw new mysqli_sql_exception($conn->error);
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
          throw new mysqli_sql_exception($conn->error);
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
      } else {
        throw new mysqli_sql_exception($conn->error);
      }
      $conn->close();
      return $arr;
  }

}

