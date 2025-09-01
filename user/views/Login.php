<?php 
session_start();
include('../helpers/session.php'); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
    <style>
        #example1 {
            text-align: center;
            background-color: orange;
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

        input[type="email"], input[type="password"] {
            width: 200px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        input[type="submit"], .btn-link {
            margin-top: 15px;
            padding: 8px 20px;
            border: none;
            background-color: maroon;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        #errorMsg {
            color: red;
        }
    </style>
</head>
<body>

<form id="login" method="post" action="../controllers/LoginController.php">
    <div id="example1">
        <h2>User Login</h2>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        <br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <br><br>

        <!-- ✅ Remember Me -->
        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label>
        <br><br>

        <input type="submit" value="Login">
        <!-- ✅ Back Button -->
        <br>
        <a href="../../index.php">
            <button type="button" class="back-button">← Back to Main Page</button>
        </a>
        <p id="errorMsg">
            <?php 
                if (isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                }
            ?>
        </p>
        
        <a href="../views/Register.php">Don't have an account? Register here</a>
        <a href='verify_user.php'>Forgot Password?</a><br><br>
    </div>
</form>

</body>
</html>