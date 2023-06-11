<?php

namespace app\model;

class purchased {
  private string $hostName , $username, $password, $database ;
  function __construct() {
    $this->hostName = 'localhost' ;
    $this->username = 'root';
    $this->password = '';
    $this->database = 'csc350';
  }
  // import from Cart Class itemQuantity function and total price (item price * quantity of item) Function
//

}