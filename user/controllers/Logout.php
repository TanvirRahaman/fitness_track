<?php
session_start();
session_destroy();
include('../helpers/session.php'); 

setcookie("user_email", "", time() - 3600, "/");
setcookie("user_name", "", time() - 3600, "/");

header("Location: ../views/Login.php");
exit();
?>