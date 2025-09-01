<?php
session_start();

// ১ মিনিট (৬০ সেকেন্ড) টাইমআউট সেট
$timeout_duration = 60;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // সেশন ধ্বংস করা হচ্ছে
    session_unset();
    session_destroy();
    header("Location: ../views/Login.php?timeout=1");
    exit();
}

// সর্বশেষ activity সময় আপডেট
$_SESSION['last_activity'] = time();
?>