<?php

namespace app\controller;

use app\model\Cart;

class CartController {

  public function handleCart() : void {
    session_start() ;
    if (isset($_SESSION['ON'])) {
      $customerId = $_SESSION['customerId'] ;
      $cartDB = new Cart() ;
      $cartData = $cartDB->getCartData($customerId) ;
      $cartTotalQuantity = $cartDB->getTotalQuantity($customerId) ;

      if ($cartTotalQuantity > 0) {
        $cartTotalPrice = $cartDB->getCartTotalPrice($customerId) ;
        $cartTotalPriceFormatted = '$' . number_format($cartTotalPrice, 2) ;
        $cartTotalPrice += $cartTotalPrice * 0.08 ;
        $cartTotalAfterTaxFormatted = '$' . number_format($cartTotalPrice, 2) ;
      } else {
        $cartTotalPrice = $cartDB->getCartTotalPrice(0) ;
        $cartTotalPriceFormatted = '$' . number_format(0, 2) ;
        $cartTotalPrice += $cartTotalPrice * 0.08 ;
        $cartTotalAfterTaxFormatted = '$' . number_format(0, 2) ;
      }

      include('..\app\view\cartTemplate.php') ;
    } else {
      header("Location: index.php?message=Invalid-Authentication") ;
    }
  }
  public function thankYouCheckout() : void {
    session_start() ;
    $customerId = $_SESSION['customerId'] ;
    $dbcart = new Cart() ;
    $dbcart->emptyAllCartItems($customerId) ;
    include('..\app\view\thankyou.php') ;
  }

}