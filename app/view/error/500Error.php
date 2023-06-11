<?php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php include __DIR__ . '\..\classes\scriptLoader.php' ?>
  <script src="Javascript/errors/500ErrorPage.js"></script>
  <title>SoleVault: Internal Server Error</title>
</head>
<body>
<?php include __DIR__ . '\..\menu.php' ?>

<div class="d-flex align-items-center justify-content-center" style="height:40vh">
  <div class="text-center">
    <h1 class="display-4">500 Error</h1>
    <p class="lead">Oops! An internal server error occurred.</p>
    <p>We apologize for the inconvenience. Please try again later.</p>
    <a href="" class="btn btn-primary" id="backToHome">Go back to the homepage</a>
  </div>
</div>

</body>
</html>
