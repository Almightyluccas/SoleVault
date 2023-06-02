<?php
use app\library\LibraryLG ;
LibraryLG::sessionValidator() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1" />
  <?php include 'classes/scriptLoader.php' ?>
  <title>GoShop: Logoff</title>

</head>
<body >
  <?php include('menu.php') ?>

  <div id="content" class="container">
    <div style="text-align: left; padding: 0;">
      <h1 style="font: normal 179% 'century gothic', arial, sans-serif;color: #43423F;margin: 0 0 15px 0;padding: 15px 0 5px 0;" >Logoff</h1>
      <div class="form_settings">
        <form action="index.php" method="get">
          <input type="hidden" name="choice" value="logoff2" />
          <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="contact_submitted" value="Logoff" />
        </form>
      </div>
    </div>

</body>
</html>