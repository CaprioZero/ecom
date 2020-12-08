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
    $viewQuery = "DELETE FROM admin_register WHERE id='$DeleteId'";
    $Execute = mysqli_query($con, $viewQuery);
    if ($Execute)
    {
        $_SESSION["SuccessMessage"] = "Admin Deleted Successfully! ";
        Redirect_to("admin.php");
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
        Redirect_to("admin.php");
    }
}
?>
