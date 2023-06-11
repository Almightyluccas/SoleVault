<?php

namespace app\model;

//TODO: fix empty auto column add if products doesn't fill full space

class Products {
  private Database $database ;
  public function __construct() {
    $this->database = new Database() ;
  }
  public function getProducts(): array {
    try {
      return $this->database->fetchFromDatabase("SELECT * FROM csc350.products");
    } catch (\mysqli_sql_exception $e) {
      error_log(var_export($e, true));
      throw $e;
    }
  }
  public function getSingleProduct($productId): array {
    try {
      return $this->database->fetchFromDatabase(
        "SELECT * FROM csc350.products WHERE productId = ?", [$productId]
      ) ;
    } catch (\mysqli_sql_exception $e) {
      error_log(var_export($e, true));
      throw $e;
    }
  }

}