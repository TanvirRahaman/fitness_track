<?php
// registerController.php
session_start();
include('../models/User.php');

// Turn on error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $gender = $_POST['gender'];

    // Check if email already exists
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Email exists
        echo "<script>
                alert('Email already exists!');
                window.location.href = '../views/Register.php';
              </script>";
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // Hash the password (for security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, gender) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $gender);

    if ($stmt->execute()) {
    echo "<script>
            alert('Registration successful!');
            window.location.href = '../views/Home.php';
          </script>";
    } else {
        echo "<script>
                alert('Error occurred while saving data.');
                window.location.href = '../views/Register.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = '../views/Register.php';
          </script>";
}
?>
