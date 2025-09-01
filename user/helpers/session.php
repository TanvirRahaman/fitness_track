<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inactivity limit (60 seconds)
$inactive_limit = 60;

// Auto logout if inactive
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_limit)) {
    session_unset();
    session_destroy();

    // Optional: Clear cookies also
    setcookie("user_email", "", time() - 3600, "/");
    setcookie("user_name", "", time() - 3600, "/");

    header("Location: ../views/Login.php?timeout=1");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Prevent session fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Utility functions

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