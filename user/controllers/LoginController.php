<?php
session_start();
include('../models/User.php');
include('../helpers/session.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); 


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        $_SESSION['login_error'] = "Database error: " . $conn->error;
        header("Location: ../views/Login.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];

            if ($remember) {
                setcookie("user_email", $user['email'], time() + (86400 * 7), "/");
                setcookie("user_name", $user['name'], time() + (86400 * 7), "/");
            }

            header("Location: ../views/Home.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: ../views/Login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "No account found with that email.";
        header("Location: ../views/Login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>