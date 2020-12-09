<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Coffee shop</a>
  <button class="navbar-toggler" 
                type="button" 
                data-toggle="collapse" 
                data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="viewcart.php">CART</a>
      </li>
      <?php if ($_SESSION['user_type'] == "admin"){ ?>
      <li class="nav-item">
                     <a class="nav-link" href="dashboard.php">Dashboard</a>
                  </li>
                  <?php } ?>
    </ul>
  </div>
</nav>