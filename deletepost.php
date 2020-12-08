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
    $viewQuery = "DELETE FROM post_detail WHERE id='$DeleteId'";
    $Execute = mysqli_query($con, $viewQuery);
    if ($Execute)
    {
        $_SESSION["SuccessMessage"] = "Post Deleted Successfully! ";
        Redirect_to("dashboard.php");
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
        Redirect_to("dashboard.php");
    }
}
?>
