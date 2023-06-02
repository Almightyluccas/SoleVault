
<!--TODO: Implement remember me functionality and forgot password functionality-->

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1" />

  <?php include 'classes/scriptLoader.php' ?>
  <title>SoleVault: Login</title>


</head>
<body class="pt-5">

  <div class="container-fluid ">
    <div class="row">
      <div class="col-lg-12 text-center" >
        <h2 class="display-3">Sole Vault: Unleash the Power of Your Soles</h2>
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

          <form action='index.php' method='get'>
            <input type='hidden' name='choice' value='logon'/>
            <div class="form-outline mb-4">
              <input type="text" id="username" class="form-control form-control-lg" name='username'/>
              <label class="form-label contact" for="username">Username</label>
            </div>
            <div class="form-outline mb-4">
              <input type="password" id="password" class="form-control form-control-lg" name='password'/>
              <label class="form-label contact" for="password">Password</label>
              <?php
              if(isset($_GET['messsage'])) echo "<div class='' style='color:red;width:500px'>".$_GET['message']."</div>";
              if(isset($message)) echo "<div style='color:red;width:500px; font-size: 20px'>".$message."</div>";
              ?>
            </div>
            <div class="d-flex justify-content-around align-items-center mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3"> Remember me </label>
              </div>
              <a href="#!">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block submit"
                    name="contact_submitted" value="submit">Sign in</button>
            <div class="divider  align-items-center my-2">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>
            <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="index.php?choice=registration"
               role="button">
              <span>Register</span>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>



</body>
</html>

