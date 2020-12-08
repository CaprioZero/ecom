<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php require_once ("includes/redirector.php"); ?>
<?php require_once ("includes/checkaccount.php"); ?>
<?php Confirm_login(); ?>
<?php
if (isset($_GET["id"]))
{
    global $con;
    $DeleteId = $_GET["id"];
    $viewQuery = "DELETE FROM category WHERE id='$DeleteId'";
    $Execute = mysqli_query($con, $viewQuery);
    if ($Execute)
    {
        $_SESSION["SuccessMessage"] = "Category Deleted Successfully! ";
        Redirect_to("categories.php");
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
        Redirect_to("categories.php");
    }
}
?>
