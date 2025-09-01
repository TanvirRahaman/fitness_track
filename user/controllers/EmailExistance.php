<?php
// EmailExistance.php
include('../models/User.php');

session_start();


if(isset($_POST['check_email']))
{
	$email = $_POST['email'];
	
	$checkemail = "SELECT email FORM user WHERE email='$email'";
	$checkemail_run = mysqli_query($con, $checkemail);

if(mysqli_num_rows($checkemail_run) > 0)
{
	echo "Email Already Exist";
}	
else
{
	
}
}

?>