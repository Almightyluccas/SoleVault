<?php
\app\library\LibraryLG::sessionValidator() ;
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php include 'classes/scriptLoader.php' ?>
  <script src="Javascript/ajax/productAjax.js" defer> </script>
  <title>Document</title>
  <style>
    #title {
      color: white;
      font-size: 30px;
    }

    .button {
      background: black;
      font-size: 15px;
    }

  </style>

</head>
<body >



    <?php include('menu.php'); ?>


<div class="container ">
  <?php
  $itemGenDir = __DIR__ . '/../view/classes/itemGeneration.php';
  include $itemGenDir ;

  $itemGen = new \app\view\classes\itemGeneration() ;
  if (isset($products)){
    $itemGen->displayProducts($products, 3);
  } else {
    error_log('there was an error generating the products at Products.php $products variable ') ;
  }
  ?>
</div>


</body>
</html>