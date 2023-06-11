<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Products;

class ProductsController {

  public function handleMainProductPage() : void {
    $productGen = new Products() ;
    $products = $productGen->getProducts() ;
    include '..\app\view\products.php' ;
  }

  public function handleSinglePage() : void {
    $productId = LibraryLG::getValue('productId') ;
    $routedFrom = LibraryLG::getValue('frm') ;
    $retrieveProduct = new Products() ;
    $product = $retrieveProduct->getSingleProduct($productId) ;
    include '..\app\view\singleProduct.php' ;
  }

  public function handleHomePage() : void {
    include('..\app\view\home.php') ;
  }

}