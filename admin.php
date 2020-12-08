<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<?php require_once ("includes/checkaccount.php"); ?>
<?php Confirm_login(); ?>
<?php
if (isset($_POST["submit"]))
{
    $Username = mysqli_real_escape_string($con, trim($_POST["username"]));
    $Password = mysqli_real_escape_string($con, trim($_POST["password"]));
    $ConfirmPassword = mysqli_real_escape_string($con, trim($_POST["passConfirm"]));
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $CurrentTime = time();
    $DateTime = strftime("%d-%m-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["UserName"];
    if (empty($Username) || empty($Password) || empty($ConfirmPassword))
    {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("admin.php");
    }
    elseif (strlen($Password) < 6)
    {
        $_SESSION["ErrorMessage"] = "Password should be greater than 6 characters";
        Redirect_to("admin.php");
    }
    elseif ($Password !== $ConfirmPassword)
    {
        $_SESSION["ErrorMessage"] = "Password and Confirm Password should match";
        Redirect_to("admin.php");
    }
    else
    {
        // Query to insert category in DB When everything is fine
        global $con;
        $Query = "INSERT INTO admin_register(datetime,username,password,addby) VALUES ('$DateTime','$Username','".md5($Password)."','$Admin')";
        $Execute = mysqli_query($con, $Query);

        if ($Execute)
        {
            $_SESSION["SuccessMessage"] = "Admin added Successfully";
            Redirect_to("admin.php");
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("admin.php");
        }
    }
} //Ending of Submit Button If-Condition

?>
<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
      <link rel="icon" href="img/wallpaper.jpg" type="image/jpg" sizes="32x32">
      <title>Admin</title>
      <!-- Custom styles for this template -->
      <link href="css/style.css" rel="stylesheet">
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
      <link href="dashboard.css" rel="stylesheet">
   </head>
   <body>
      <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
         <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">FYSVN</a>
         <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
               <a class="nav-link" href="logout.php">Sign out</a>
            </li>
         </ul>
      </nav>
      <div class="container-fluid">
         <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
               <div class="sidebar-sticky pt-3">
                  <ul class="nav flex-column">
                     <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-columns"></i>
                        <span data-feather="home"></span>
                        Dashboard
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="addnewpost.php"><i class="fas fa-plus"></i>
                        <span data-feather="file"></span>
                        Add new post
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="categories.php"><i class="fas fa-tags"></i>
                        <span data-feather="shopping-cart"></span>
                        Categories
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-users-cog"></i>
                        <span data-feather="users"></span>
                        Admin list <span class="sr-only">(current)</span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" rel="noopener noreferrer" target="_blank" href="index.php?page=1"><i class="far fa-eye"></i>
                        <span data-feather="layers"></span>
                        View blog
                        </a>
                     </li>
                  </ul>
               </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h1 class="h2">Manage Admins</h1>
               </div>
               <div class="container-fluid">
                  <?php
echo ErrorMessage();
echo SuccessMessage();
?>
                  <form class="" action="admin.php" method="post">
                     <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                     </div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                     </div>
                     <div class="form-group">
                        <label for="passConfirm">Comfirm password</label>
                        <input type="password" name="passConfirm" class="form-control" id="passConfirm">
                     </div>
                     <button type="submit" name="submit" class="btn btn-success">Add new user</button>
                  </form>
               </div>
               <br>
               <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover">
                     <thead class="thead-dark">
                        <tr>
                           <th>No. </th>
                           <th>Date & Time</th>
                           <th> Username</th>
                           <th>Added by</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <?php
global $con;
$viewQuery = "SELECT * FROM admin_register ORDER BY id desc";
$Execute = mysqli_query($con, $viewQuery);
$SrNo = 0;
while ($DataRows = mysqli_fetch_array($Execute))
{
    $AdminId = $DataRows["id"];
    $AdminDate = $DataRows["datetime"];
    $AdminUserName = $DataRows["username"];
    $AdminAdder = $DataRows["addby"];
    $SrNo++;
?>
                     <tbody>
                        <tr>
                           <td><?php echo htmlentities($SrNo); ?></td>
                           <td><?php echo htmlentities($AdminDate); ?></td>
                           <td><?php echo htmlentities($AdminUserName); ?></td>
                           <td><?php echo htmlentities($AdminAdder); ?></td>
                           <td>
                              <a class="delete" href="deleteadmin.php?id=<?php echo $AdminId; ?>">
                              <button type="submit" class="btn btn-danger">Delete</button>
                              </a>
                           </td>
                     </tbody>
                     <?php
} ?>
                  </table>
               </div>
            </main>
         </div>
      </div>
      <script src="js/jquery-3.5.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
      <script src="js/myScript.js"></script>
      <script language="JavaScript" type="text/javascript">
         $(document).ready(function(){
             $("a.delete").click(function(e){
                 if(!confirm('Are you sure?')){
                     e.preventDefault();
                     return false;
                 }
                 return true;
             });
         });
         window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
               $(".alert").remove(); 
            });
         }, 2000);
      </script>
   </body>
</html>
