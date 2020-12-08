<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<?php require_once ("includes/checkaccount.php"); ?>
<?php Confirm_login(); ?>
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
      <title>Dashboard</title>
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
                        <a class="nav-link active" href="#"><i class="fas fa-columns"></i>
                        <span data-feather="home"></span>
                        Dashboard <span class="sr-only">(current)</span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="addnewpost.php"><i class="fas fa-plus"></i>
                        <span data-feather="file"></span>
                        Add new product
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="categories.php"><i class="fas fa-tags"></i>
                        <span data-feather="shopping-cart"></span>
                        Categories
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="fas fa-users-cog"></i>
                        <span data-feather="users"></span>
                        Admin list
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" rel="noopener noreferrer" target="_blank" href="index.php?page=1"><i class="far fa-eye"></i>
                        <span data-feather="layers"></span>
                        View product page
                        </a>
                     </li>
                  </ul>
               </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h1 class="h2">Product Dashboard</h1>
               </div>
               <?php
echo ErrorMessage();
echo SuccessMessage();
?>
               <div class="container-fluid">
                  <table class="table table-striped table-hover">
                     <thead class="thead-dark">
                        <tr>
                           <th>No.</th>
                           <th>Title</th>
                           <th>Thumbnail</th>
                           <th>Author</th>
                           <th>Date&Time</th>
                           <th>Category</th>
                           <th>Actions</th>
                           <th>Detail</th>
                        </tr>
                     </thead>
                     <?php
$SrNo = 0;
global $con;
$viewQuery = "SELECT * FROM post_detail ORDER BY id desc";
$Execute = mysqli_query($con, $viewQuery);
$SrNo = 0;
while ($DataRows = mysqli_fetch_array($Execute))
{
    $PostId = $DataRows["id"];
    $DateTime = $DataRows["datetime"];
    $PostTitle = $DataRows["title"];
    $Category = $DataRows["category"];
    $Admin = $DataRows["author"];
    $Image = $DataRows["image"];
    $PostDescription = $DataRows["post"];
    $SrNo++;
?>
                     <tbody>
                        <tr>
                           <td><?php echo $SrNo; ?></td>
                           <td><?php echo $PostTitle; ?></td>
                           <td><img id="post_img" src="uploads/<?php echo htmlentities($Image); ?>" style="object-fit: contain; width: 100%; height: 100px;" alt="Card image cap"></td>
                           <td><?php echo $Admin; ?></td>
                           <td><?php echo $DateTime; ?></td>
                           <td><?php echo $Category; ?></td>
                           <td>
                              <a href="editpost.php?id=<?php echo $PostId; ?>">
                              <button type="submit" class="btn btn-warning">Edit</button>
                              </a>
                              <br>
                              <br>
                              <a class="delete" href="deletepost.php?id=<?php echo $PostId; ?>">
                              <button type="submit" class="btn btn-danger">Delete</button>
                              </a>
                           </td>
                           <td> <a rel="noopener noreferrer" target="_blank" href="fullpost.php?id=<?php echo $PostId; ?>">
                              <span class="btn btn-info">Preview</span>
                              </a>
                           </td>
                        </tr>
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
