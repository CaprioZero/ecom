<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<?php require_once ("includes/checkaccount.php"); ?>
<?php Confirm_login(); ?>
<?php
if (isset($_POST["submit"]))
{
    $title = mysqli_real_escape_string($connection, $_POST["postTitle"]);
    $category = mysqli_real_escape_string($connection, $_POST["categoryTitle"]);
    $Image = $_FILES["imageSelect"]["name"];
    $Target = "uploads/" . basename($_FILES["imageSelect"]["name"]);
    $Description = mysqli_real_escape_string($connection, $_POST["postArea"]);
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $CurrentTime = time();
    $DateTime = strftime("%d-%m-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $Price = mysqli_real_escape_string($connection, $_POST["price"]);
    if (empty($title))
    {
        $_SESSION["ErrorMessage"] = "Please fill out title";
        Redirect_to("addnewpost.php");
    }
    elseif (strlen($title) > 1999)
    {
        $_SESSION["ErrorMessage"] = "Title should be less than than 2000 characters";
        Redirect_to("addnewpost.php");
    }
    else
    {
        // Query to insert category in DB When everything is fine
        global $connection;
        $Query = "INSERT INTO items(datetime,title,category,image,post) VALUES ('$DateTime','$title','$category','$Image','$Description','$Price')";
        $Execute = mysqli_query($connection, $Query);
        move_uploaded_file($_FILES["imageSelect"]["tmp_name"], $Target);
        if ($Execute)
        {
            $_SESSION["SuccessMessage"] = "Product added Successfully";
            Redirect_to("dashboard.php");
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("addnewpost.php");
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
      <title>New post</title>
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
      <link href="css/style.css" rel="stylesheet">
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
                        <a class="nav-link" href="#"><i class="fas fa-columns"></i>
                        <span data-feather="home"></span>
                        Dashboard
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link active" href="postdashboard.php"><i class="fas fa-columns"></i>
                        <span data-feather="home"></span>
                        Add new product <span class="sr-only">(current)</span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="commentdashboard.php"><i class="fas fa-columns"></i>
                        <span data-feather="home"></span>
                        Categories
                        </a>
                     </li>
                     <?php if ($_SESSION['user_type'] == "admin"){ ?>
                     <li class="nav-item">
                        <a class="nav-link" href="editpermission.php"><i class="fas fa-plus"></i>
                        <span data-feather="file"></span>
                        Change user permission
                        </a>
                     </li>
                     <?php } ?>
                     <li class="nav-item">
                        <a class="nav-link" rel="noopener noreferrer" target="_blank" href="index.php"><i class="far fa-eye"></i>
                        <span data-feather="layers"></span>
                        View product page
                        </a>
                     </li>
                  </ul>
               </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h1 class="h2">Add new post</h1>
               </div>
               <div class="container-fluid">
                  <?php
echo ErrorMessage();
echo SuccessMessage();
?>
                  <form class="" action="addnewproduct.php" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="postTitle">Title</label>
                        <input type="text" name="postTitle" class="form-control" id="postTitle">
                     </div>
                     <div class="form-group">
                        <label for="categoryTitle">Choose category</label>
                        <select class="form-control" id="categoryTitle" name="categoryTitle">
                           <?php
global $connection;
$viewQuery = "SELECT * FROM category ORDER BY id desc";
$Execute = mysqli_query($connection, $viewQuery);
while ($DataRows = mysqli_fetch_array($Execute))
{
    $CategoryId = $DataRows["id"];
    $CategoryName = $DataRows["name"];
?>
                           <option> <?php echo $CategoryName; ?></option>
                           <?php
} ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="imageSelect">Select Image</label>
                        <input class="form-control" type="file" name="imageSelect" id="imageSelect">
                     </div>
                     <div class="form-group">
                        <label for="postArea">Product description</label>
                        <textarea class="form-control" name="postArea" id="postArea" rows="9"></textarea>
                     </div>
                     <div class="form-group">                       
                        <input type="number" id="replyNumber" min="0" step="1" name="price" data-bind="value:replyNumber" />
                     </div>
                     <button type="submit" name="submit" class="btn btn-success">Add new post</button>
                  </form>
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
            window.setTimeout(function() {
               $(".alert").fadeTo(500, 0).slideUp(500, function(){
                  $(".alert").remove(); 
               });
            }, 2000);
         });
      </script>
   </body>
</html>
