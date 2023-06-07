<?php

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php   include __DIR__ . '\..\classes\scriptLoader.php'  ?>
  <script src="Javascript/404ErrorPage.js"></script>
  <title>SoleVault: Page not found </title>
</head>
<body>

<?php  include __DIR__. '\..\menu.php'?>

<div class="d-flex align-items-center justify-content-center" style="height:40vh">
  <div class="text-center">
    <h1 class="display-4">404 Error</h1>
    <p class="lead">Oops! The page you're looking for could not be found.</p>
    <a href="" class="btn btn-primary" id="backToHome">Go back to the homepage</a>
  </div>
</div>

</body>
</html>
