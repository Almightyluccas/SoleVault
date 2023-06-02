<?php

namespace app\model;

//TODO: fix empty auto column add if products doesn't fill full space

class Products
{
  private string $serverName, $dbUsername, $dbPassword, $dbName;
  function __construct() {
    $this->serverName = 'localhost' ;
    $this->dbUsername = 'root';
    $this->dbPassword = '';
    $this->dbName = 'csc350';
  }
  function getProducts() : array {

      $conn = mysqli_connect($this->serverName, $this->dbUsername, $this->dbPassword, $this->dbName);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      $sql = "SELECT * FROM csc350.products";
      $result = mysqli_query($conn, $sql);
      $products = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
      }
      mysqli_close($conn);
      return $products;

  }

  function getSingleProduct ($productId) : array {
    $product = [] ;
    $conn = mysqli_connect($this->serverName, $this->dbUsername, $this->dbPassword, $this->dbName);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM csc350.products 
            WHERE productId = $productId " ;
    $result = mysqli_query($conn, $sql) ;
    while ($row = mysqli_fetch_assoc($result)) {
      $product[] = $row;
    }
    mysqli_close($conn);

    return $product ;
  }

}