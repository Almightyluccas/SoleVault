<?php
namespace app\controller;

use app\core\Router;
use app\model\Cart;
use mysqli_sql_exception;

class CartController {

  private Cart $cartDB ;

  public function __construct () {
    $this->cartDB = new Cart() ;
  }

  public function handleCart() : void {
    session_start() ;
    if (isset($_SESSION['ON'])) {
      $customerId = $_SESSION['customerId'];
      try {
        try {
          $cartData = $this->cartDB->getCartData($customerId);
        } catch (mysqli_sql_exception $e) {
          error_log(var_export($e, true)) ;
          Router::redirect(['choice' => 'err500']) ;
          exit() ;
        }
        try {
          $cartTotalQuantity = $this->cartDB->getTotalQuantity($customerId);
        } catch (mysqli_sql_exception $e) {
          error_log(var_export($e, true));
          Router::redirect(['choice' => 'err500']);
          exit() ;
        }
        if ($cartTotalQuantity > 0) {
          try {
            $cartTotalPrice = $this->cartDB->getCartTotalPrice($customerId);
          } catch (mysqli_sql_exception $e) {
            error_log(var_export($e, true));
            Router::redirect(['choice' => 'err500']);
            exit() ;
          }
          $cartTotalPriceFormatted = '$' . number_format($cartTotalPrice, 2);
          $cartTotalPrice += $cartTotalPrice * 0.08;
          $cartTotalAfterTaxFormatted = '$' . number_format($cartTotalPrice, 2);
        } else {
          try {
            $cartTotalPrice = $this->cartDB->getCartTotalPrice(0);
          } catch (mysqli_sql_exception $e) {
            error_log(var_export($e, true));
            Router::redirect(['choice' => 'err500']);
            exit() ;
          }
          $cartTotalPriceFormatted = '$' . number_format(0, 2);
          $cartTotalPrice += $cartTotalPrice * 0.08;
          $cartTotalAfterTaxFormatted = '$' . number_format(0, 2);
        }
        include(__DIR__ . '/../view/cartTemplate.php');
      } catch (mysqli_sql_exception $e) {
        error_log(var_export($e, true));
        Router::redirect(['choice' => 'err500']);
      }
    } else {
      Router::redirect(['message' => 'Invalid-Authentication']);
    }
  }
  public function thankYouCheckout() : void {
    session_start() ;
    $customerId = $_SESSION['customerId'] ;
    try {
      $this->cartDB->emptyAllCartItems($customerId) ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      Router::redirect(['choice' => 'err500']) ;
    }
    include(__DIR__ . '/../view/thankyou.php') ;
  }
}
