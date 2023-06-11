<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


use app\core\Autoloader ;
use app\model\Cart ;
require_once ('../../core/Autoloader.php') ;
Autoloader::register() ;


  $data = json_decode(file_get_contents('php://input'), true);
  $productId = intval($data['productId']);
  $quantity = intval($data['quantity']) ;
  session_start() ;


  try {
    $cart = new Cart() ;
    $cart->addItem(intval($_SESSION['customerId']) ,$productId,$quantity) ;
    $productName = $cart->getProductName($productId) ;
    echo $productName;
  } catch (mysqli_sql_exception $e) {
    error_log(var_export($e, true)) ;
    var_dump($e) ;
  }








