<?php
namespace app\model;

use mysqli_sql_exception ;


class Cart {
  private Database $database ;
  public function __construct() {
    $this->database = new Database() ;
  }

	function addItem(int $customerId, int $productId, int $quantity) : void {
      try {
        $result = $this->database->fetchFromDatabase(
          "SELECT * FROM csc350.cart WHERE customerId = '$customerId' AND productId = ? ",
          [$productId]
        ) ;
        if (!empty($result)) {
          $row = $result[0];
          $existingQuantity = $row['quantity'];
          $newQuantity = $existingQuantity + $quantity;

          try {
            $this->database->queryDatabase(
              "UPDATE csc350.cart SET quantity = ? WHERE customerId = ? AND productId = ?",
              [$newQuantity, $customerId, $productId]
            );
          } catch (mysqli_sql_exception $e) {
            error_log(var_export($e, true));
            throw $e ;
          }
        } else {
          try {
            $productResult = $this->database->fetchFromDatabase(
              "SELECT * FROM csc350.products WHERE productId = ? ",
              [$productId]
            );
            $product_row = $productResult[0] ;
            try {
              $this->database->queryDatabase(
                "INSERT INTO csc350.cart (customerId, productId, quantity, price) VALUES (?, ?, ?, ?)",
                [$customerId, $productId, $quantity, $product_row['price']]
              );
            } catch (mysqli_sql_exception $e) {
              error_log(var_export($e, true));
              throw $e ;
            }
          } catch (mysqli_sql_exception $e) {
            error_log(var_export($e, true));
            throw $e ;
          }
        }
		} catch (mysqli_sql_exception $e) {
        error_log(var_export($e, true));
        throw $e ;
		}
	}

	public function getCartData(int $customerId) : array {
		try {
      return $this->database->fetchFromDatabase(
        "SELECT c.customerId, c.productId, c.quantity, c.price, p.imageUrl, p.productName
        FROM csc350.cart c
        INNER JOIN csc350.products p ON c.productId = p.productId 
        WHERE c.customerId = ?",
        [$customerId]
      ) ;
		} catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true));
      throw $e ;
		}
	}

	function emptySingleCartItem(int $customerId, int $productId) : void {
    try {
      $this->database->queryDatabase(
        "DELETE FROM csc350.cart WHERE customerId = ? AND productId = ?" ,
        [$customerId, $productId]
      ) ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }
	}

  function updateCartItemQuantity(int $customerId, int $productId, int $quantity) : void {
    try {
      $this->database->queryDatabase(
        "UPDATE csc350.cart
        SET quantity = ?
        WHERE customerId = ? AND productId = ? " ,
        [$quantity, $customerId, $productId]
      ) ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }
  }
	function emptyAllCartItems(int $customerId) : void {
		try {
      $this->database->queryDatabase(
        "DELETE FROM csc350.cart WHERE customerId = ? " ,
        [$customerId]
      ) ;
		}catch(mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
		}
	}
	function getProductName(int $productId) : string {
    try {
      $result = $this->database->fetchFromDatabase(
        "SELECT productName FROM csc350.products WHERE productId = ?" ,
        [$productId]
      ) ;
      if (!empty($result)) {
        return $result[0]['productName'] ;
      }
      throw new mysqli_sql_exception("productName is empty for: $productId") ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }
  }

	function getItemQuantity(int $customerId, int $productId) : int {
    try {
      $result = $this->database->fetchFromDatabase(
        "SELECT quantity FROM csc350.cart WHERE customerId = ? AND productId = ?",
        [$customerId, $productId]
      ) ;
      return !empty($result) ? $result[0]['quantity'] : 0 ;

    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }

	}
	public function getTotalQuantity (int $customerId) : int {
    try {
      $result = $this->database->fetchFromDatabase(
        "SELECT SUM(quantity) AS totalQuantity FROM csc350.cart WHERE customerId = ?" ,
        [$customerId]
      ) ;
      return !empty($result) ? intval($result[0]['totalQuantity']) : 0 ;

    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }
	}
	function getItemPrice($customerId, $productId) : float {
    return 0 ;
	}
	function getItemTotalCost(int $customerId, int $productId) : float {
		return $this->getItemQuantity($customerId, $productId) * $this->getItemPrice($customerId, $productId);
	}
	public function getCartTotalPrice(int $customerId) : float {
    try {
      $result = $this->database->fetchFromDatabase(
        "SELECT SUM(quantity * price) AS totalPrice FROM csc350.cart WHERE customerId = ?" ,
        [$customerId]
      ) ;
      return !empty($result) ? floatval($result[0]['totalPrice']) : 0 ;

    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      throw $e ;
    }
	}
  public function getCartTotalPriceAfterTax(int $customerId) : float {
    $total = $this->getCartTotalPrice($customerId) ;
    $total += $total * 0.08 ;
    return  $total;
  }
}
