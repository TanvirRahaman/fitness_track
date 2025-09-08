<?php
session_start();
include('../models/User.php');
include('../helpers/session.php'); 

$email = $_SESSION['email'] ?? null;

if (!$email) {
    header("Location: Login.php");
    exit();
}

$sql = "SELECT name, email, gender FROM users WHERE email='$email'";
$result = $conn->query($sql);
$employee = $result->fetch_assoc();

$showSuccessAlert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $conn->real_escape_string($_POST['name']);
    $new_gender = $conn->real_escape_string($_POST['gender']);

    $update_sql = "UPDATE users SET name='$new_name', gender='$new_gender' WHERE email='$email'";

    if ($conn->query($update_sql) === TRUE) {
        $showSuccessAlert = true;
    } else {
        $message = "❌ Error updating profile: " . $conn->error;
    }

    $sql = "SELECT name, email, gender FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $employee = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Profile</title>
    <style>
        body {
            background-color: moccasin;
            font-family: Arial, sans-serif;
        }

        #example4 {
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
            width: 350px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .button-container {
            display: flex;
            flex-direction: column; /* column style */
            gap: 10px;
            margin-top: 20px;
        }

        button, .btn-link, .btn-logout {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            width: 100%; /* full width button */
            box-sizing: border-box;
        }

        button {
            background-color: #056f1eff;
            color: black;
        }

        button:hover {
            background-color: #fcfcfcff;
        }

        .btn-link {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-link:hover {
            background-color: #0056b3;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="example4">
        <h2>Profile Information</h2>

        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

        <form method="POST" id="profileForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required />

            <label for="email">Email:</label>
            <input type="text" id="email" value="<?= htmlspecialchars($employee['email']) ?>" readonly />

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male" <?= $employee['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $employee['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $employee['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>

            <div class="button-container">
                <button type="submit">Update</button>
                <a href="../views/Home.php" class="btn-link">Back</a>
                <a href="../controllers/logout.php" class="btn-logout">Logout</a>
            </div>
        </form>
    </div>

    <?php if ($showSuccessAlert): ?>
        <script>
            alert("✅ Profile updated successfully!");
            window.location.href = '../views/Home.php';
        </script>
    <?php endif; ?>
</body>
</html>