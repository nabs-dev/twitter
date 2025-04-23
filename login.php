<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $db->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, password FROM users WHERE email = '$email'";
    $result = $db->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: dashboard.php");
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetClone - Log In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #15202B;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #192734;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        h1 {
            color: #1DA1F2;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 1rem;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #253341;
            color: #ffffff;
        }
        .btn {
            background-color: #1DA1F2;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #1991DB;
        }
        .signup-link {
            text-align: center;
            margin-top: 1rem;
        }
        .signup-link a {
            color: #1DA1F2;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Log In to TweetClone</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Log In</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
