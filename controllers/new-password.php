<?php
require_once '../config/db.php';
require_once '../config/messages.php';
$email = $_POST["email"];
$reset_token = $_POST["reset_token"];
$new_password = $_POST["password1"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$user = mysqli_fetch_object($result);
	if ($user->reset_token == $reset_token)
	{	
		$password_hash = password_hash($new_password, PASSWORD_BCRYPT);
		$sql = "UPDATE users SET reset_token='', password='$password_hash' WHERE email='$email'";
		mysqli_query($connection, $sql);

		$_SESSION["SuccessMessage"] = "Password has been changed";
		header('Location: loginpage.php');
	}
	else
	{
		echo "Recovery email has been expired";
	}
}
else
{
	echo "Email does not exists";
}
