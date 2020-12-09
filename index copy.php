<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Blog Home</title>
      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
      <link rel="icon" href="img/wallpaper.jpg" type="image/jpg" sizes="32x32">
      <!-- Custom styles for this template -->
      <link href="css/blog-home.css" rel="stylesheet">
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
         <div class="container">
            <a class="navbar-brand" href="index.php?page=1">FYSVN</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="index.php?page=1">Home
                     <span class="sr-only">(current)</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="dashboard.php">Dashboard</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <!-- Page Content -->
      <div class="container">
         <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
               <h1 class="my-4">Welcome
               </h1>
               <?php
global $con;
if (isset($_GET["searchButton"]))
{
    $Search = $_GET["search"];
    $viewQuery = "SELECT * FROM post_detail WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
}
elseif (isset($_GET["category"]))
{
    $Category = $_GET["category"];
    $viewQuery = "SELECT * FROM post_detail WHERE category='$Category' ORDER BY id desc";
}
elseif (isset($_GET["page"]))
{
    $Page = $_GET["page"];
    if ($Page == 0 || $Page < 1)
    {
        $ShowPostFrom = 0;
    }
    else
    {
        $ShowPostFrom = ($Page * 5) - 5;
    }
    $viewQuery = "SELECT * FROM post_detail ORDER BY id desc LIMIT $ShowPostFrom,5";
}
else
{
    $viewQuery = "SELECT * FROM post_detail ORDER BY id desc LIMIT 0,5";
}
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
?>
               <!-- Blog Post -->
               <div class="card mb-4">
                  <img class="card-img-top post_img" src="uploads/<?php echo htmlentities($Image); ?>" alt="Card image cap">
                  <div class="card-body">
                     <h2 class="card-title"><?php echo htmlentities($PostTitle); ?></h2>
                     <p class="card-text"><?php if (strlen($PostDescription) > 150)
    {
        $PostDescription = substr($PostDescription, 0, 150) . "...";
    }
    echo htmlentities($PostDescription); ?></p>
                     <a rel="noopener noreferrer" target="_blank" href="fullpost.php?id=<?php echo $PostId; ?>" class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                     Posted on <?php echo htmlentities($DateTime); ?> by
                     <?php echo htmlentities($Admin); ?>
                     <p class="text-muted">Category: <?php echo htmlentities($Category); ?></p>
                  </div>
               </div>
               <?php
} ?>
               <!-- Pagination -->
               <nav aria-label="Page navigation example">
               <ul class="pagination justify-content-center mb-4">
               <?php if (isset($Page))
{
    if ($Page > 1)
    { ?>
                  <li class="page-item">
                     <a class="page-link" href="index.php?page=<?php echo $Page - 1; ?>">&larr; Older</a>
                  </li>
                  <?php
    }
} ?>
                  <?php
global $con;
$viewQuery = "SELECT COUNT(*) FROM post_detail";
$Execute = mysqli_query($con, $viewQuery);
$RowPagination = mysqli_fetch_array($Execute);
$TotalPosts = array_shift($RowPagination);
$PostPagination = $TotalPosts / 5;
$PostPagination = ceil($PostPagination);
for ($i = 1;$i <= $PostPagination;$i++)
{
    if (isset($Page))
    {
        if ($i == $Page)
        { ?>
              <li class="page-item active">
                <a href="index.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
              </li>
              <?php
        }
        else
        {
?>  <li class="page-item">
                  <a href="index.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                </li>
            <?php
        }
    }
} ?>
                  <?php if (isset($Page) && !empty($Page))
{
    if ($Page + 1 <= $PostPagination)
    { ?>
                  <li class="page-item">
                     <a class="page-link" href="index.php?page=<?php echo $Page + 1; ?>">Newer &rarr;</a>
                  </li>
                  <?php
    }
} ?>
               </ul>
               </nav>
            </div>
            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">
               <!-- Search Widget -->
               <div class="card my-4">
                  <h5 class="card-header">Search</h5>
                  <div class="card-body">
                     <form class="form-inline d-none d-sm-block" action="index.php">
                        <div class="form-group">
                           <input class="form-control mr-2" type="text" name="search" placeholder="Search here">
                           <button class="btn btn-primary" name="searchButton">Go</button>
                        </div>
                     </form>
                  </div>
               </div>
               <!-- Categories Widget -->
               <div class="card my-4">
                  <h5 class="card-header">Categories</h5>
                  <div class="card-body">
                     <?php
global $con;
$viewQuery = "SELECT * FROM category ORDER BY id desc";
$Execute = mysqli_query($con, $viewQuery);
while ($DataRows = mysqli_fetch_array($Execute))
{
    $CategoryId = $DataRows["id"];
    $CategoryName = $DataRows["name"];
?>
                     <a href="index.php?category=<?php echo $CategoryName; ?>"> <span class="heading"> <?php echo $CategoryName; ?></span> </a><br>
                     <?php
} ?>
                  </div>
               </div>
               <!-- Side Widget -->
               <div class="card my-4">
                  <h5 class="card-header">Newest Posts</h5>
                  <div class="card-body">
                     <?php
global $con;
$viewQuery = "SELECT * FROM post_detail ORDER BY datetime desc LIMIT 0,5";
$Execute = mysqli_query($con, $viewQuery);
while ($DataRows = mysqli_fetch_array($Execute))
{
    $PostId = $DataRows['id'];
    $PostTitle = $DataRows['title'];
    $DateTime = $DataRows['datetime'];
    $Image = $DataRows['image'];
?>
                     <div class="media">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start"  style="object-fit: contain; width: 50%; height: 70px;" alt="">
                        <div class="media-body ml-2">
                           <a style="text-decoration:none;"href="fullpost.php?id=<?php echo htmlentities($PostId); ?>" rel="noopener noreferrer" target="_blank">
                              <h6 class="lead"><?php echo htmlentities($PostTitle); ?></h6>
                           </a>
                           <p class="small"><?php echo htmlentities($DateTime); ?></p>
                        </div>
                     </div>
                     <hr>
                     <?php
} ?>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container -->
      <!-- Footer -->
      <footer class="py-5 bg-dark">
         <div class="container">
            <p class="m-0 text-center text-white">
               <script>document.write(new Date().getFullYear())</script>, made by DMN
            </p>
         </div>
         <!-- /.container -->
      </footer>
      <!-- Bootstrap core JavaScript -->
      <script src="js/jquery-3.5.1.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
   </body>
</html>
