<?php
session_start();
include('../helpers/session.php'); 

// ✅ Check if logged in (via session or cookie)
if (!isset($_SESSION['email'])) {
    if (isset($_COOKIE['user_email']) && isset($_COOKIE['user_name'])) {
        // Restore session from cookie
        $_SESSION['email'] = $_COOKIE['user_email'];
        $_SESSION['name'] = $_COOKIE['user_name'];
    } else {
        header("Location: Login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <style>
        body {
            background-color: moccasin; 
            margin: 0;
            padding: 0;
            display: flex;
        }

        .home {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: orange; 
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: white; 
            color: black;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }

        .sidebar form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="home">
        <div class="sidebar">
            <p>✅ Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
            <button onclick="location.href='Profile.php'">Profile</button>
            <button onclick="location.href='verify_user.php'">Change Password</button>

            <!-- ✅ Logout Button for Employee -->
            <form action="../controllers/Logout.php" method="post">
                <button type="submit" class="logout-btn">🔓 Logout</button>
            </form>
        </div>
    </div>
</body>
</html>