<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<?php require_once ("includes/checkaccount.php"); ?>
<?php
if (isset($_POST["submit"]))
{
    $Username = $_POST["inputUsername"];
    $Password = $_POST["inputPassword"];
    $AccountExist = Log_in($Username, $Password);
    $_SESSION["UserId"] = $AccountExist["id"];
    $_SESSION["UserName"] = $AccountExist["username"];
    if ($AccountExist)
    {
        $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["UserName"]}";
        Redirect_to("dashboard.php");
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Invalid username or password";
        Redirect_to("login.php");
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <!-- Bootstrap CSS -->
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
      <link rel="icon" href="img/wallpaper.jpg" type="image/jpg" sizes="32x32">
    <title>Log in</title>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">
  
    <form class="form-signin" action="login.php" method="post">
    <p class="mt-5 mb-3 text-muted">                  <?php
echo ErrorMessage();
echo SuccessMessage();
?></p>
  <img class="mb-4" src="img/wallpaper.jpg" alt="">
  <h1 class="h3 mb-3 font-weight-normal">Welcome back</h1>
  <label for="inputUsername" class="sr-only">Username</label>
  <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Log in</button>
  <p class="mt-5 mb-3 text-muted"><script>document.write(new Date().getFullYear())</script></p>
</form>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/myScript.js"></script>
<script language="JavaScript" type="text/javascript">
         $(document).ready(function(){
            window.setTimeout(function() {
              $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(".alert").remove(); 
              });
            }, 2000);
          });
      </script>
</body>
</html>
