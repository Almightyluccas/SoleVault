<?php
\app\core\library\LibraryLG::sessionValidator() ;?>



<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1" />



<?php include 'classes/scriptLoader.php' ?>
<script src="Javascript/ajax/homeAjax.js" defer> </script>
<title>GoShop: Home</title>
<style type="text/css">

  #title {
    color : white;
    font-size: 30px;
  }

  .button {
    background: black;
    font-size: 15px;
  }

  body {
    background: url('https://i.imgur.com/H2X4g9O.jpg') no-repeat center/cover;;
    height: 100%;
    width: 100%;
    margin-bottom:480px;
    background-size: 50% 100%;
    background-color: #ffffff;
  }

  h1 {
    color: black;
    font-weight: bold;
    font-size: 45px;
    margin-left: 50px;

  }

  h2 {
    margin-left: 140px;
    color: black;
    font-weight: bold;
    font-size: 35px;
  }

  #button {
    margin-left: 250px;
    background-color:red;
    border: none;
    color: white;
    padding: 18px 35px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    border-radius: 20px;
    font-weight: bold;
  }

  #price {
    margin-left: 290px;
    font-weight: bold;
    font-size: 20px;
    color: black;

  }

  #gat {
    margin-left: 80px;
  }

  #sale {
    margin-left: 700px;
    font-size: 30px;
    color: black;
  }

</style>
</head>

<body>


    <?php include('menu.php'); ?>


<br>
<h1><center>JORDAN 4 COLLECTION</center></h1><br>
<p id="sale"> STUDENTS SALE 10% OFF </p><br>
<br><br><br><br><br><br><br>
<br>
<div id="gat">
  <h2>Jordan 4 Retro Thunder</h2><br>


  <p id="price"> $150.00 </p><br>
  <input type="button" id="button" class="btn buttonCart" data-productId="11"
         value="Add to cart">
</div>
<br>


</div>



</body>
</html>