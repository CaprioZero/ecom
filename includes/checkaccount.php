<?php require_once ("includes/db.php"); ?>
<?php require_once ("includes/sessions.php"); ?>
<?php
function Log_in($Username, $Password)
{
    global $con;
    $viewQuery = "SELECT * FROM admin_register WHERE username='$Username' AND password='".md5($Password)."'";
    $Execute = mysqli_query($con, $viewQuery);
    if ($admin = mysqli_fetch_array($Execute))
    {
        return $admin;
    }
    else
    {
        return null;
    }
}

function Confirm_login()
{
    if (isset($_SESSION["UserId"]))
    {
        return true;
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Login Required!";
        Redirect_to("login.php");
    }
}
?>
