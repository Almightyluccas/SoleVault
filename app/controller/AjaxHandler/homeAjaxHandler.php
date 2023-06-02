<?php


error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

use app\model\Cart;

require "../../model/Cart.php";

  $data = json_decode(file_get_contents('php://input'), true);
  $productId = intval($data['productId']);

  session_start();

  $cart = new Cart();
  $cart->addItem($_SESSION['customerId'], $productId, 1);
  $productName = $cart->getProductName($productId);
  echo $productName;

