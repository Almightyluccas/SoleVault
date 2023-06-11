<?php
\app\core\library\LibraryLG::sessionValidator() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../app/view/css/confetti_cuisine.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    #title {
      color: white;
      font-size: 30px;
    }

    .button {
      background: black;
      font-size: 15px;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 100px;
    }

    h1 {
      text-align: center;
      color: black;
    }

    p {
      margin-bottom: 20px;
      font-size: 18px;
    }

    .mission-statement {
      font-weight: bolder;
      font-size: 20px;
    }
  </style>
</head>
<body>


    <?php include('menu.php'); ?>


<div class="container">
  <div class="row">
    <div class="col-md-6">
      <img src="https://i.imgur.com/xeOmC8V.jpg" alt="Sneaker Image" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h1><b>Our Story</b></h1>
      <p>Welcome to Your Elite Sneakers, where every step is a statement. We curate a collection of sneakers that represents style, innovation, and self-expression.</p>
      <p>At Your Elite Sneakers, we believe sneakers are more than just footwear. They are a powerful form of art, culture, and personal identity. We provide a platform to explore and celebrate the world of sneakers.</p>
      <p>Our mission is to fuel your sneaker passion by offering a handpicked selection of sought-after sneakers. From iconic classics to cutting-edge collaborations, we deliver the ultimate sneaker experience.</p>
      <p>With a team of passionate sneaker enthusiasts, we understand the thrill of finding the perfect pair. Our collection embodies quality, authenticity, and the latest trends.</p>
      <p>Customer satisfaction is at the heart of everything we do. We strive to provide exceptional service, ensuring your sneaker journey is extraordinary.</p>
    </div>
  </div>
</div>

</body>
</html>