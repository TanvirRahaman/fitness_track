<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <style>
        body {
            background-color: moccasin;
            font-family: Arial, sans-serif;
        }

        #example2 {
            background-color: maroon;
            color: white;
            text-align: center;
            margin: auto;
            position: absolute;
            border: 2px solid black;
            padding: 50px;
            border-radius: 25px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #f0ad4e;
            color: black;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ec971f;
        }

        .login-redirect {
            margin-top: 15px;
            font-size: 0.95em;
        }

        .login-redirect a {
            background-color: green;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-redirect a:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>
    <div id="example2">
        <h2>Registration</h2>

        <form id="register" action="../controllers/registerController.php" method="POST" onsubmit="return isValidR();">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Enter your name" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" class="email_id" placeholder="Enter your email" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" placeholder="Confirm your password" required><br>

            <label>Gender:</label><br>
            <input type="radio" id="female" name="gender" value="Female"><label for="female">Female</label>
            <input type="radio" id="male" name="gender" value="Male" required><label for="male">Male</label>
            <input type="radio" id="other" name="gender" value="Other"><label for="other">Other</label>
            <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

        <div class="login-redirect">
            🔒 Already have an account? 
            <a href="Login.php">Login</a>
        </div>
    </div>

    <script>
        function isValidR() {
            var name = document.getElementById("name").value.trim();
            var email = document.getElementById("email").value.trim();
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var gender = document.querySelector('input[name="gender"]:checked');

            if (!name || !email || !password || !confirmPassword || !gender) {
                alert("All fields are required.");
                return false;
            }

            if (!/\S+@\S+\.\S+/.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>