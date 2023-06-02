<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Products;

class ProductsController {

  public function productPage() : void {
    $productGen = new Products() ;
    $products = $productGen->getProducts() ;
    include '..\app\view\products.php' ;
  }

  public function singlePage() : void {
    $productId = LibraryLG::getValue('productId') ;
    $routedFrom = LibraryLG::getValue('frm') ;
    $retrieveProduct = new Products() ;
    $product = $retrieveProduct->getSingleProduct($productId) ;
    include '..\app\view\singleProduct.php' ;
  }

  public function homePage() : void {
    include('..\app\view\home.php') ;
  }

}