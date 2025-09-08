<?php
session_start();

$timeout_duration = 60;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ../views/Login.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();
?>