<?php require_once ("config/redirector.php"); ?>
<?php     
    session_start();
    session_destroy();
      
    Redirect_to("loginpage.php");
;?>