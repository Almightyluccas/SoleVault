<?php

use app\core\library\LibraryLG;

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

  <div class="d-flex flex-column align-items-center justify-content-center" style="height: 40vh;">
    <div style="text-align: left; padding: 0;">
      <h1 style="font: normal 179% 'century gothic', arial, sans-serif;color: #43423F;margin: 0 0 15px 0;" >Sign Out</h1>
      <div class="form_settings">
        <form action="index.php" method="get">
          <input type="hidden" name="choice" value="logoff2" />
          <p style="padding-top: 15px"><span>&nbsp;</span><button class="btn btn-primary">Sign Out</button>
        </form>
      </div>
    </div>

</body>
</html>