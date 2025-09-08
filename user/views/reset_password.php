<?php
session_start();
include('../models/User.php');

if (!isset($_SESSION['reset_email'])) {
    header("Location: verify_user.php");
    exit();
}

$message = "";
$email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            unset($_SESSION['reset_email']);
            echo "<script>
                alert('✅ Password changed successfully! Please log in.');
                window.location.href = 'Login.php';
            </script>";
            exit();
        } else {
            $message = "Error updating password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Reset Password</title>
    <style>
        body { background-color: moccasin; font-family: Arial, sans-serif; }

        #container {
            background-color: maroon; 
            color: white; width: 350px; padding: 40px;
            border-radius: 15px; 
            margin: 100px auto; 
            text-align: center;
        }

        input, button { 
            padding: 10px; margin: 10px 0; width: 90%; 
            border-radius: 5px; border: none; }

        button { 
            background-color: #f0ad4e; 
            font-weight: bold; 
            cursor: pointer; }

        .error { 
            color: yellow; 
            margin-bottom: 10px; 
        }

        a { color: lightgreen; 
            text-decoration: none; 
            margin-top: 15px; 
            display: inline-block; }

        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div id="container">
        <h2>Reset Password</h2>
        <p>Resetting password for: <b><?= htmlspecialchars($email) ?></b></p>
        <?php if ($message) echo "<div class='error'>$message</div>"; ?>
        <form method="POST">
            <input type="password" name="new_password" placeholder="New Password" required />
            <input type="password" name="confirm_password" placeholder="Confirm Password" required />
            <button type="submit">Change Password</button>
        </form>
        <a href="Login.php">Back to Login</a>
    </div>
</body>
</html>