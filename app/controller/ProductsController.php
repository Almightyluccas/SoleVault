<?php

namespace app\controller;

use app\core\library\LibraryLG;
use app\core\Router;
use app\model\Products;
use mysqli_sql_exception;

class ProductsController {

  public function handleMainProductPage() : void {
    try {
      $productGen = new Products() ;
      $products = $productGen->getProducts() ;
      include __DIR__ . '/../view/products.php' ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      Router::redirect(['choice' => 'err500']) ;
    }
  }

  public function handleSinglePage() : void {
    try {
      $productId = LibraryLG::getValue('productId') ;
      $routedFrom = LibraryLG::getValue('frm') ;
      $retrieveProduct = new Products() ;
      $product = $retrieveProduct->getSingleProduct($productId) ;
      include __DIR__ . '/../view/singleProduct.php' ;
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      Router::redirect(['choice' => 'err500']) ;
    }
  }

  public function handleHomePage() : void {
    include __DIR__ . '/../view/home.php' ;
  }

}