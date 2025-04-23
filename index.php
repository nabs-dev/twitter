<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetClone - Welcome</title>
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
            text-align: center;
            background-color: #192734;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        h1 {
            color: #1DA1F2;
        }
        p {
            margin-bottom: 2rem;
        }
        .btn {
            background-color: #1DA1F2;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #1991DB;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to TweetClone</h1>
        <p>Experience the power of real-time communication and stay connected with your friends and the world.</p>
        <a href="signup.php" class="btn">Get Started</a>
    </div>
</body>
</html>
