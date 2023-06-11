<?php
\app\core\library\LibraryLG::sessionValidator() ;

use app\view\classes\itemGeneration;

?>




<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="Javascript/ajax/productAjax.js" defer></script>

  <?php include 'classes/scriptLoader.php' ?>
  <title>Document</title>


</head>
<body >

    <?php include('menu.php'); ?>



<div class="container ">
  <div class="pt-5">
    <?php
    if(isset($routedFrom) && $routedFrom == 'products')  {
      echo '<h6 class="mb-0"><a href="index.php?choice=products" class="text-body"><i
          class="fas fa-long-arrow-alt-left me-2"></i>Back to store</a></h6>' ;
    } else if(isset($routedFrom) && $routedFrom == 'cart') {
      echo '<h6 class="mb-0"><a href="index.php?choice=cart" class="text-body"><i
          class="fas fa-long-arrow-alt-left me-2"></i>Back to cart</a></h6>' ;
    }



    ?>

  </div>

  <?php

  $itemGen = new itemGeneration() ;

  if (isset($product)) {
    $itemGen->displaySingleProduct($product) ;
  } else {
    error_log('there was an error generating the products at Products.php $products variable ') ;
  }


  ?>

</div>












</body>
</html>
