<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once '../vendor/autoload.php';
require_once '../config/db.php';

$email = $_POST["email"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$reset_token = md5(rand().time());

	$sql = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";
	mysqli_query($connection, $sql);

	$message='<p>Dear user,</p>';
	$message = "<p>Please click the link below to reset your password</p>";
	$message.='<p>-------------------------------------------------------------</p>';
	$message .= "<a href='http://localhost/classroom/newpasswordpage.php?email=$email&reset_token=$reset_token'>";
	$message .= "Reset password";
	$message .= "</a>";
	$message.='<p>-------------------------------------------------------------</p>';
	$message.='<p>Please be sure to copy the entire link into your browser.
	The link will expire after 1 day for security reason.</p>';
	$message.='<p>If you did not request this forgotten password email, no action 
	is needed, your password will not be reset. However, you may want to log into 
	your account and change your security password as someone may have guessed it.</p>';   
	$message.='<p>Thanks,</p>';

	send_mail($email, "Reset password", $message);
}
else
{
	echo "Email does not exists";
}

function send_mail($to, $subject, $message)
{
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Set mailer to use SMTP
	    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'Something';                     // SMTP username
	    $mail->Password   = 'Something';                               // SMTP password
	    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
	    $mail->Port       = 587;                                    // TCP port to connect to

	    $mail->setFrom('donotreply@mydomain.com', 'The coffee shop team');
	    //Recipients
	    $mail->addAddress($to);

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $subject;
	    $mail->Body    = $message;

	    $mail->send();
	    echo '<div class="alert alert-success">
		Mail has been sent.
	</div>';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
