<?php require_once ("config/db.php"); ?>
<?php require_once ("config/messages.php"); ?>
<?php
function Confirm_login()
{
    if (isset($_SESSION['id']))
    {
        return true;
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Login Required!";
        header('Location: loginpage.php');
    }
}
?>