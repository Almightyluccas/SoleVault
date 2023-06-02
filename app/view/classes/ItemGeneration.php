<?php

namespace app\view\classes;
class ItemGeneration {
  public function cardTemplate($productName, $productPrice, $productImage, $productDescription, $productId) : string {
    return '
    <div class="col">
      <div class="card ">
        <img class="card-img-top img-fluid" src="' . $productImage . '" alt="'.$productName.'">
        <div class="card-body">
          <a href="index.php?choice=singleProduct&productId='.$productId.'&frm=products" 
          class="card-title h5 productName">' . $productName . '
          </a>
          <p class="card-text h5">$' . $productPrice . '</p>
<a href="javascript:void(0)" class="show-description-btn  bg-transparent pl-0  text-decoration-none text-muted text-1"
       style="text-decoration: none ;">Show Description</a>          
          <p class="card-text product-description d-none  ">' . $productDescription . '</p>
          <div class="input-group pl-0 mb-3 col-sm-5">
            <div class="input-group-prepend">
              <button class="btn btn-outline-secondary  decreaseQuantity" type="button">-</button>
            </div>
            <input type="text" class="form-control form-control-sm quantitySelector text-center" 
            value="1" aria-label="Quantity">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary increaseQuantity" style="color:black;"  type="button">+</button>
            </div>
          </div>
          <input type="button" class="btn btn-secondary addToCartBtn" data-productId="' . $productId . '"
            value="Add to cart">
        </div>
      </div>
    </div>';
  }

  public function cardTemplateSingle($productName,$productPrice,$productImage,$productDescription,$productId):string {
    return '
    <section class="py-5 card-body">
            <div class="container px-6 px-lg-3 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="' . $productImage . '" alt="...">
                    </div>
                    <div class="col-md-6">
                        <div class="small mb-1">SKU: ' . $productId . '</div>
                        <h1 class="display-5 fw-bolder">' . $productName . '</h1>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through">$ ' . $productPrice . ' </span>
                            
                        </div>
                        <p class="lead" style="width: 25vw;">' . $productDescription . '</p>
                         <div class="input-group pl-0 mb-3 col-sm-4">
                          <div class="input-group-prepend">
              <button class="btn btn-outline-secondary decreaseQuantity" type="button">-</button>
            </div>
            <input type="text" class="form-control form-control-sm quantitySelector text-center" value="1" 
            aria-label="Quantity">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary increaseQuantity" style="color:black;"  type="button">+</button>
            </div>
          </div>
          <input type="button" class="btn btn-secondary addToCartBtn" data-productId="' . $productId . '"
            value="Add to cart">
                    </div>
                </div>
            </div>
        </section>';
  }
  private function cartTemplate($productId,$productName, $price, $imageUrl, $quantity) : string {
    return '
    <hr class="my-4">
    <div class="row mb-4 d-flex justify-content-between align-items-center">
      <div class="col-md-2 col-lg-2 col-xl-2">
        <img src="' . $imageUrl . '" class="img-fluid rounded-3" alt="' . $productName . '">
      </div>
      <div class="col-md-3 col-lg-3 col-xl-3">
        <a href="index.php?choice=singleProduct&productId='.$productId.'&frm=cart" class="text-muted">
        ' . $productName . '
        </a>
      </div>
      <div class="col-md-3 col-lg-3 col-xl-2 d-flex" >
        <div class="col-sm-12">
        <input id="form" min="1" name="quantity" value="' . $quantity . '" type="number" 
        class="form-control form-control-sm itemQuantityCart" data-productId="' . $productId . '" />
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
        <h6 class="mb-0">$' . $price . '</h6>
      </div>
      <div class="col-md-1 col-lg-1 col-xl-1 text-end">
        <button type="button" class="close removeProductCart" aria-label="close"  data-productId="' . $productId . '" >
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>';
  }
  private function addCardRow($rowLength, $iterator, $columnsPerRow) : string {
    if ($iterator === 0 ) {
      return '<div class="row mb-4 my-4">' ;
    }
    if ($iterator % $columnsPerRow === 0) {
      return '</div><div class="row mb-4 my-4">' ;
    }else if ($iterator  === $rowLength) {
      return '</div>' ;
    }else {
      return '' ;
    }
  }
  private function addBlankCard($rowLength, $iterator, $columnsPerRow) : string {
    $missingSpaces = $columnsPerRow - ($rowLength % $columnsPerRow);
    if ($missingSpaces > 0 && $iterator === $rowLength - 1 && $missingSpaces < $columnsPerRow) {
      $output = str_repeat('<div class="col"></div>', $missingSpaces);
      return $output;
    } else {
      return '';
    }
  }
  public function displaySingleProduct($product) : void {
    $output = '';
    foreach ($product as $products) {
      $productId = $products['productId'];
      $productName = $products['productName'];
      $productPrice = $products['price'];
      $productImage = $products['imageUrl'];
      $productDescription = $products['description'];
    }
    $productPriceFormatted = number_format($productPrice, 2, '.', ',') ;
    $output .= $this->addCardRow(count($product), 0,1)
      . $this->cardTemplateSingle($productName, $productPriceFormatted, $productImage, $productDescription, $productId)
      . '</div>' ;
    echo $output ;

  }
  public function displayProducts($products, $productsPerRow = 3) : void {

    $output = '';
    $iterator = 0;
    foreach ($products as $product) {
      $productId = $product['productId'];
      $productName = $product['productName'];
      $productPrice = $product['price'];
      $productImage = $product['imageUrl'];
      $productDescription = $product['description'];

      $productPriceFormatted = number_format($productPrice, 2, '.', ',') ;
      $output .= $this->addCardRow(count($products), $iterator, $productsPerRow)
        . $this->cardTemplate($productName, $productPriceFormatted, $productImage, $productDescription, $productId)
        . $this->addBlankCard(count($products), $iterator, $productsPerRow) ;
      $iterator++;
    }
    echo $output;
  }
  public function displayCart($cart) : void {

    $output = '';
    foreach ($cart as $carts) {
      $productId = $carts['productId'];
      $quantity = $carts['quantity'];
      $price = $carts['price'];
      $imageUrl = $carts['imageUrl'];
      $productName = $carts['productName'];

      $formattedPrice = number_format($price, 2) ;
      $output .= $this->cartTemplate($productId, $productName,$formattedPrice,$imageUrl,$quantity);
    }
    echo $output;
  }


}
