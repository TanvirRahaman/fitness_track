<?php
session_start();
include('../models/User.php');
include('../helpers/session.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // ✅ Remember Me checkbox

    // Step 1: Prepare a secure statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        $_SESSION['login_error'] = "Database error: " . $conn->error;
        header("Location: ../views/Login.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Step 2: Check if email exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // ✅ Step 3: Use password_verify here!
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];

            // ✅ Remember Me Cookies (valid for 7 days)
            if ($remember) {
                setcookie("user_email", $user['email'], time() + (86400 * 7), "/");
                setcookie("user_name", $user['name'], time() + (86400 * 7), "/");
            }

            header("Location: ../views/Home.php");
            exit();
        } else {
            // ❌ Wrong password
            $_SESSION['login_error'] = "❌ Incorrect password.";
            header("Location: ../views/Login.php");
            exit();
        }
    } else {
        // ❌ Email not found
        $_SESSION['login_error'] = "❌ No account found with that email.";
        header("Location: ../views/Login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>