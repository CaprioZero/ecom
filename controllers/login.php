<?php require_once ("config/redirector.php"); ?>
<?php require_once ("config/messages.php"); ?>
<?php
   
    // Database connection
    include('./config/db.php');

    global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $email_empty_err, $pass_empty_err;

    if(isset($_POST['login'])) {
        $email_signin        = $_POST['email_signin'];
        $password_signin     = $_POST['password_signin'];

        // clean data 
        $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
        $pswd = mysqli_real_escape_string($connection, $password_signin);

        // Query if email exists in db
        $sql = "SELECT * From users WHERE email = '{$email_signin}' ";
        $query = mysqli_query($connection, $sql);
        $rowCount = mysqli_num_rows($query);

        // If query fails, show the reason 
        if(!$query){
           die("SQL query failed: " . mysqli_error($connection));
        }

        if(!empty($email_signin) && !empty($password_signin)){
            if(strlen($_password) < 6) {
                $wrongPwdErr = '<div class="alert alert-danger">
                        Password should be between 6 to 20 charcters long.
                    </div>';
            }
            // Check if email exist
            if($rowCount <= 0) {
                $accountNotExistErr = '<div class="alert alert-danger">
                        User account does not exist.
                    </div>';
            } else {
                // Fetch user data and store in php session
                while($row = mysqli_fetch_array($query)) {
                    $id            = $row['id'];
                    $email         = $row['email'];
                    $pass_word     = $row['password'];
                    $user_type     = $row['user_type'];
                }

                // Verify password
                $password = password_verify($password_signin, $pass_word);

                // Allow only verified user
                    if($email_signin == $email && $password_signin == $password) {
                       $_SESSION['id'] = $id;
                       $_SESSION['email'] = $email;
                       $_SESSION['user_type'] = $user_type;
                        if ($_SESSION['user_type'] == "admin"){
                            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["lastname"]}";
                            Redirect_to("dashboard.php");
                        }
                        else if ($_SESSION['user_type'] == "user"){
                            Redirect_to("index.php");
                        }

                    } else {
                        $emailPwdErr = '<div class="alert alert-danger">
                                Either email or password is incorrect.
                            </div>';
                    }
            }

        } else {
            if(empty($email_signin)){
                $email_empty_err = "<div class='alert alert-danger email_alert'>
                            Email not provided.
                    </div>";
            }
            
            if(empty($password_signin)){
                $pass_empty_err = "<div class='alert alert-danger email_alert'>
                            Password not provided.
                        </div>";
            }            
        }

    }

?>    