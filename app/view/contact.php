<?php
\app\library\LibraryLG::sessionValidator() ;
?>
<!Doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php include 'classes/scriptLoader.php' ?>
  <title>GoShop: Contact</title>


  <style type="text/css">
    #content { text-align: left;
      color: #00308F;
      width: 500px;
      padding: 0px;}

    .form_settings
    { margin: 0px 0 0 0;}

    .form_settings p
    { padding: 0 0 0px 0;}


    .form_settings span
    { float: left;
      width: 200px;
      text-align: left;}

    .form_settings input, .form_settings textarea
    { padding: 5px;
      width: 350px;
      height: 40px;
      font: 100% arial;
      border: 3px solid #E5E5DB;
      background: #FFF;
      color: #47433F;
      border-color: black;
      border-radius: 25px;
    }


    .form_settings .submit
    { font: 100% arial;
      border: 2px;
      width: 99px;
    //margin: 0 0 0 212px;
      margin: 1 1 1 1;
      height: 33px;
      padding: 2px 0 3px 0;
      cursor: pointer;
      background: black;
      color: white;
      font-weight: bold;
      border-radius: 35px;
      font-size: 18px;}

    .form_settings textarea, .form_settings select
    { font: 100% arial;
      width: 299px;}

    .form_settings select
    { width: 310px;}

    .form_settings .checkbox
    { margin: 4px 0;
      padding: 0;
      width: 14px;
      border: 0;
      background: none;}

    form {
      text-align: center;
      padding-bottom: 100px;
    }

    #touch {
      text-align: center;
      font-size: 135px;
      color: gray;
      margin-bottom: -20px;
      font: arial;
    }

    #hold {
      text-align: center;
      font-size: 28px;
      color: white;
      font: arial;
      margin-left: 0px;
      margin-right: 0px;
      margin-top: 20px;
    }

    #title {
      color : white;
      font-size: 30px;
    }

    .button {
      background: black;
      font-size: 15px;
    }

    body {
      background-color: white;
      background: url(p1.jpeg);
      height: 100%;
      width: 100%;
    }

    <style>
       /* CSS styles */
     body {
       font-family: Arial, sans-serif;
       background-color: #f4f4f4;
       margin: 0;
       padding: 0;
     }

    .container {
      max-width: 800px;
      margin-top: 10px;
      padding: 40px;
      color: black;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 20px;
      background: rgba(255,255,255,0.5);
      font-size: 20px;
    }

    h1 {
      text-align: center;
      color: black;
    }

    form {
      margin-top: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
    }

    input,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #dddddd;
      border-radius: 10px;
    }

    textarea {
      height: 150px;
    }

    button {
      display: block;
      width: 100%;
      padding: 12px;
      background-color: black;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: black;
    }
  </style>

  </style>

</head>
<body>



    <?php include('menu.php'); ?>


<center>
  <div style='width:600px' id="menu">
    <table align=center>
      <tr>

      </tr>
    </table>
  </div>
</center>

<center>
  <div class="container">
    <h1><b>Contact Us</b></h1><br>
    <p> Reach out to us and step into a world of sneaker excellence. Our team is eagerly waiting to assist you in finding the perfect pair, answering any questions, or simply sharing your passion for sneakers. Don't hesitate to drop us a message – let's take your sneaker journey to new heights together! </p>
    <form>
      <div class="form-group">
        <input type="text" id="name" name="name" placeholder="Enter Name" required>
      </div>
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Enter Email" required>
      </div>
      <div class="form-group">
        <textarea id="message" name="message" placeholder="Enter Message" required></textarea>
      </div>
      <button type="submit">Send </button>
    </form>
  </div>
</center>

</body>
</html>