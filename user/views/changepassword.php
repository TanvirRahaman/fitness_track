<?php
session_start();
include('../models/User.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        $message = "You must be logged in to change password.";
    } else {
        $email = $_SESSION['email'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $message = "User not found!";
        } elseif (!password_verify($current_password, $user['password'])) {
            $message = "Current password is incorrect.";
        } elseif ($new_password !== $confirm_new_password) {
            $message = "New passwords do not match.";
        } elseif ($current_password === $new_password) {
            $message = "New password cannot be the same as the current password.";
        } else {

            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hashedPassword, $email);

            if ($update_stmt->execute()) {
                $message = "✅ Password updated successfully!";
            } else {
                $message = "⚠️ Error updating password: " . $conn->error;
            }

            $update_stmt->close();
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        #example3 {
            background-color: orange;
            text-align: center;
            margin: auto;
            position: absolute;
            justify-content: center;
            border: 2px solid black;
            padding: 50px;
            border-radius: 25px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        div.absolute {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        p {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <div id="example3">
        <h2>Change Password</h2>
        <p id="message"><?php if (!empty($message)) { echo $message; } ?></p>
        
        <form id="changePassword" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>
            <br><br>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <br><br>
            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" id="confirm_new_password" name="confirm_new_password" required>
            <br><br>
            
            <button type="submit" class="button">Update Password</button>
        </form>
        <div class="absolute">
            <a href="../controllers/Logout.php">Logout</a>
        </div>
    </div>

    <script>
        document.getElementById('changePassword').addEventListener('submit', function(e) {
            var currentPassword = document.getElementById('current_password').value;
            var newPassword = document.getElementById('new_password').value;
            var confirmNewPassword = document.getElementById('confirm_new_password').value;
            var errorMsg = document.getElementById('message');

            if (currentPassword === newPassword) {
                e.preventDefault();
                errorMsg.textContent = "New password cannot be the same as the current password.";
                return;
            }

            if (newPassword !== confirmNewPassword) {
                e.preventDefault();
                errorMsg.textContent = "New passwords do not match.";
                return;
            }
        });
    </script>
</body>
</html>