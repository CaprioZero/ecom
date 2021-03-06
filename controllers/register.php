<?php
   
    // Database connection
    include('./config/db.php');
    
    // Error & success messages
    global $success_msg, $email_exist, $_emailErr, $_passwordErr, $_mobileErr, $_addressErr;
    global $emailEmptyErr, $passwordEmptyErr, $mobileEmptyErr, $addressEmptyErr;
    
    // Set empty form vars for validation mapping
    $_email = $_password = "";

    if(isset($_POST["submit"])) {
        $email         = $_POST["email"];
        $password      = $_POST["password"];
        $mobilenumber  = $_POST["mobilenumber"];
        $address  = $_POST["address"];

        // check if email already exist
        $email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
        $rowCount = mysqli_num_rows($email_check_query);


        // PHP validation
        // Verify if form values are not empty
        if(!empty($email) && !empty($password) && !empty($mobilenumber) && !empty($address)){
            
            // check if user email already exist
            if($rowCount > 0) {
                $email_exist = '
                    <div class="alert alert-danger" role="alert">
                        User with email already exist!
                    </div>
                ';
            } else {
                // clean the form data before sending to database
                $_email = mysqli_real_escape_string($connection, $email);
                $_password = mysqli_real_escape_string($connection, $password);
                $_mobile_number = mysqli_real_escape_string($connection, $mobilenumber);
                $_address = mysqli_real_escape_string($connection, $address);

                // perform validation

                if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                    $_emailErr = '<div class="alert alert-danger">
                            Email format is invalid.
                        </div>';
                }
                if(!preg_match("/^[0-9]{10}+$/", $_mobile_number)) {
                    $_mobileErr = '<div class="alert alert-danger">
                            Only 10-digit mobile numbers allowed.
                        </div>';
                }
                elseif (strlen($_password) < 6) {
                    $_passwordErr = '<div class="alert alert-danger">
                             Password should be between 6 to 20 charcters long.
                        </div>';
                }
                
                // Store the data in db, if all the preg_match condition met
                if((filter_var($_email, FILTER_VALIDATE_EMAIL)) && (strlen($_password) >= 6)){

                    // Password hash
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    // Query
                    $sql = "INSERT INTO users (datetime, email, password, phone_num, address, user_type) VALUES (now(), '{$email}', '{$password_hash}', '{$mobilenumber}', '{$address}', 'user')";
                    
                    // Create mysql query
                    $sqlQuery = mysqli_query($connection, $sql);
                    $_SESSION["SuccessMessage"] = "Create account successfully";
                    header('Location: loginpage.php');
                    if(!$sqlQuery){
                        die("MySQL query failed!" . mysqli_error($connection));
                    } 
                }
            }
        } else {
            if(empty($email)){
                $emailEmptyErr = '<div class="alert alert-danger">
                    Email can not be blank.
                </div>';
            }
            if(empty($mobilenumber)){
                $mobileEmptyErr = '<div class="alert alert-danger">
                    Mobile number can not be blank.
                </div>';
            }
            if(empty($password)){
                $passwordEmptyErr = '<div class="alert alert-danger">
                    Password can not be blank.
                </div>';
            }            
        }
    }
?>