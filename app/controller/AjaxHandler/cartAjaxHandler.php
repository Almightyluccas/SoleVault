<?php
error_reporting(E_ALL) ;
ini_set('error_reporting', E_ALL) ;


use app\model\Cart;

require_once '../../model/Cart.php';

  $data = json_decode(file_get_contents('php://input'), true) ;
  if (isset($data['type'])) {
    $choice = $data['type'] ;
   if ($choice == 'changeSingleItemAtOnce') {
     session_start() ;

     $productId = $data['productId'] ;
     $itemQuantity = $data['newQuantity'] ;
     $cart = new Cart() ;

     $cart->updateCartItemQuantity($_SESSION['customerId'], $productId, $itemQuantity);
     $newCartQuantity = $cart->getTotalQuantity($_SESSION['customerId']) ;
     $newCartTotalPrice = $cart->getCartTotalPrice($_SESSION['customerId']) ;
     $newCartTotalPriceAfterTax = $cart->getCartTotalPriceAfterTax($_SESSION['customerId']) ;

     $response = array(
       'message' => 'successfully received ajax request to change single cart item' ,
       'cartQuantity' => intval($newCartQuantity) ,
       'cartTotalPrice' => intval($newCartTotalPrice),
       'cartTotalPriceAfterTax' => intval($newCartTotalPriceAfterTax)

     ) ;
     echo json_encode($response) ;

   } else if($choice == 'deleteAllOfOneItem') {
     session_start() ;

     $productId = intval($data['productId']) ;
     $cart = new Cart() ;
     $cart->emptySingleCartItem($_SESSION['customerId'], $productId) ;

     $newCartQuantity = $cart->getTotalQuantity($_SESSION['customerId']) ;
     $newCartTotalPrice = $cart->getCartTotalPrice($_SESSION['customerId']) ;
     $newCartTotalPriceAfterTax = $cart->getCartTotalPriceAfterTax($_SESSION['customerId']) ;

     $response = array(
       'message' => 'successfully received ajax request to delete all of one item' ,
       'cartQuantity' => $newCartQuantity ,
       'cartTotalPrice' => $newCartTotalPrice ,
       'cartTotalPriceAfterTax' => $newCartTotalPriceAfterTax
     ) ;
     echo json_encode($response) ;
   }
  }else {
    echo 'failed to grab $choice' ;
  }

