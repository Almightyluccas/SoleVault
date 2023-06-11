<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1" />
  <?php include 'classes/scriptLoader.php' ?>
  <title>SoleVault: Registration</title>

</head>
<body class="">
<?php include 'menu.php'?>

<div class="container-fluid ">
  <div class="row">
    <div class="col-lg-12 text-center" >
    </div>
  </div>
</div>

<div class="container-fluid " style="padding-top: 15vh">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://i.imgur.com/6iR5i2i.jpg?1"
             class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h2 class="text-center pb-3">Register Here !</h2>
        <form action='index.php' method='get'>
          <input type='hidden' name='choice' value='register' />
          <div class="form-outline mb-2">
            <input type="text" id="username" class="form-control form-control-lg" name='username'/>
            <label class="form-label contact" for="username">Username</label>
          </div>
          <div class="form-outline mb-2">
            <input type="password" id="password" class="form-control form-control-lg" name='password'/>
            <label class="form-label contact" for="password">Password</label>
          </div>
          <div class="form-outline mb-2">
            <input type="password" id="password" class="form-control form-control-lg" name='password2'/>
            <label class="form-label contact" for="password">Confirm Password</label>
            <?php
              if(isset($_GET['messsage'])) echo "<div style='color:red;width:330px'>".$_GET['message']."</div>";
              if(isset($message)) echo "<div style='color:red;width:330px'>".$message."</div>";
            ?>
          </div>
          <input type="submit" class="submit btn btn-primary btn-lg btn-block" href="index.php?choice=registration"
             role="button" value="Register">
          <div class="divider  align-items-center my-2">
            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
          </div>
          <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="index.php?choice=login"
             role="button">
            <span>Back to login</span>
          </a>
        </form>
      </div>
    </div>
  </div>
</div>






</body>
</html>