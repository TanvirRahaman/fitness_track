<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$inactive_limit = 60;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_limit)) {
    session_unset();
    session_destroy();

    setcookie("user_email", "", time() - 3600, "/");
    setcookie("user_name", "", time() - 3600, "/");

    header("Location: ../views/Login.php?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

function getSession($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}

function checkSession($key) {
    return isset($_SESSION[$key]);
}

function removeSession($key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

function destroySession() {
    session_unset();
    session_destroy();
}