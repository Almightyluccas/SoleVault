<?php


error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use app\core\Autoloader ;
use app\model\Cart ;
require_once ('../../core/Autoloader.php') ;
Autoloader::register() ;

  $data = json_decode(file_get_contents('php://input'), true);
  $productId = intval($data['productId']);

  session_start();

  $cart = new Cart();
  try {
    $cart->addItem($_SESSION['customerId'], $productId, 1);
  } catch (mysqli_sql_exception $e ) {
    echo $e ;
  }

  $productName = $cart->getProductName($productId);
  echo $productName;

