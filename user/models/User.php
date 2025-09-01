<?php
$conn = new mysqli("localhost", "root", "", "userlist");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
