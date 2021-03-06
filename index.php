<?php session_start();
//----------------------------------------------
require_once("includes/error.php");
require_once("includes/header.php");
require_once("dbclass/Dbpdo.class.php");
require_once("functions/misc.php");
require_once("functions/cart.php");
require_once("classes/clsinput.php");
require_once("config/db.php");
//----------------------------------------------

//THE FOLLOWING TWO ITEMS CONTROL THE PAGING :
$paging				= true;
$pagesize 			= 10;		//The size of a page in row numbers
//*************************************************

$startrow 			= 0;		//The row to begin display from (normally 0)
$pageno 			= 1;		//The number of the page to be displayed for the first page (normally 1)
//----------------------------------------------

//----------------------------------------------
if ($paging == true) {
	if (isset($_GET['page'])) {			
		$pageno = $_GET['page'];				
        if (!is_numeric($pageno)) {exit;}
		$startrow = ($pageno - 1) * $pagesize;
	} else {
		$pageno = 1;
		$startrow = 0;
	}	
}


//----------------------------------------------
$submitAction		= input::get('action');
$submitRecid		= input::get('recid');
$_SESSION['from'] 	= curPageURL();

//$submitFromURL	= input::get('from');
$submitFromURL = "";
if ($submitAction == "add") {
	if ( checkrecid($submitRecid) != 0 ) {
		$physical = 1;	//is always physical in this case
		add($submitRecid, $submitFromURL, $physical);
	}		
}

//-----------------------------------------
//Find number of items in the cart
if ( isset($_SESSION['session_cart']) ){
	$numberincart = count($_SESSION['session_cart']);
}else{
	$numberincart = 0;
}


?>
<?php
require_once("includes/menu.php");
?>

<div class="container">

      <div class="shoppingproducts">

          <div class="row">
            <div class="col-md-12">
              <h2>Fast Shopping Cart</h2>
            </div>
          </div>

          <div class="row">
            	<div class="col-md-12">
					<p>
						<span class="basket-setting"><?php echo($numberincart); ?><a href="viewcart.php">&nbsp;Basket</a>&nbsp;<i class="fa fa-shopping-basket fa-1x" aria-hidden="true"></i></span>
						<br/>
					</p>
				</div>
			</div>

          <div class="row">
                <div class="col-md-12">
                  <img src="assets/shopping_cart.png" alt="Shopping cart image" class="img-fluid" />
                </div>
          </div>

          <div class="row">
                <div class="col-md-12">
                  <hr>
                </div>
          </div>

          <?php
          //Retrieve all product items
          $productdetails = publishedproducts($paging, $startrow, $pagesize);
          $totalrowcount = count( publishedproducts(false, "", "") );
          ?>
		  <div class="row">
				<div class="col-md-4">            
					&nbsp;
				</div>
                <div class="col-md-4">            
                    <?php
                    if ($totalrowcount == 0)
                    {
                    echo("No records found");
                    }					
                    ?>
                </div>
				<div class="col-md-4">            
					&nbsp;
				</div>				
          </div>

          <div class="row row-eq-height">

                <?php
				foreach( $productdetails as $d_row ) {
					$recid = $d_row["recid"];		
				?>

                    <div class="col-sm-6 col-md-4 col-lg-3">

                        <h2>
                            <a href="detail.php?recid=<?php echo($recid); ?>" class="product"><?php echo($d_row['title']); ?></a>
                        </h2>

                        <img  src="uploads/<?php echo( $d_row['image'] ); ?>"
                            class="img-fluid img-thumbnail rounded"
                            style="max-width:100%; height:auto; padding-top:15px;border: none;"
                            alt="<?php echo($d_row['title']); ?>"
                            width="150" />
<br>                            <span><?php echo($d_row['category']); ?></span>
                        <p class="cost"><?php echo($d_row['price']); ?> VND</p>
        
      					<p>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<input type="hidden" name="recid" value="<?php echo($recid); ?>" />
							<input type="hidden" name="action" value="add" />
							<input type="hidden" name="from" value="<?php echo ($_SERVER['PHP_SELF']); ?>" />
							<button type="submit" class="btn btn-info">Add to cart</button>
						</form>
						</p>                          

                        <p><a href="detail.php?recid=<?php echo($d_row['recid']); ?>" class="product">See more...</a></p>

                    </div>

                 <?php
                 }
                 ?>

           </div>

       </div> <!-- End shoppingproducts -->
<hr>
<!-- Sidebar Widgets Column -->
<div class="col-md-4">
               <!-- Categories Widget -->
               <div class="card my-4">
                  <h5 class="card-header">Categories</h5>
                  <div class="card-body">
                     <?php
global $connection;
$viewQuery = "SELECT * FROM category ORDER BY id desc";
$Execute = mysqli_query($connection, $viewQuery);
while ($DataRows = mysqli_fetch_array($Execute))
{
    $CategoryId = $DataRows["id"];
    $CategoryName = $DataRows["name"];
?>
                     <span class="heading"> <?php echo $CategoryName; ?></span><br>
                     <?php
} ?>
                  </div>
               </div>
               <!-- Side Widget -->
       <?php
        require_once("includes/copyright.php");
        ?>

</div> <!-- End container -->

<?php
require_once("includes/footer.php");
?>

