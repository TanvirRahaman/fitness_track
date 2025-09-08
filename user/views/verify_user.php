<?php
session_start();
include('../models/User.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE name=? AND email=?");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "Name and Email do not match any user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Verify User</title>
    <style>
        body { background-color: moccasin; font-family: Arial, sans-serif; }
        #container {
            background-color: maroon; color: white; width: 350px; padding: 40px;
            border-radius: 15px; margin: 100px auto; text-align: center;
        }
        input, button { padding: 10px; margin: 10px 0; width: 90%; border-radius: 5px; border: none; }
        button { background-color: #f0ad4e; font-weight: bold; cursor: pointer; }
        .error { color: yellow; margin-bottom: 10px; }
        a { color: lightgreen; text-decoration: none; margin-top: 15px; display: inline-block; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div id="container">
        <h2>Verify Your Identity</h2>
        <?php if ($message) echo "<div class='error'>$message</div>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Enter your full name" required />
            <input type="email" name="email" placeholder="Enter your email" required />
            <button type="submit">Verify</button>
            <a href="../views/Home.php" class="btn-link">Back</a>
        </form>
    </div>
</body>
</html>
