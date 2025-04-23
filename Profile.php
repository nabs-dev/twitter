<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $db->query($sql);
$user = $result->fetch_assoc();

$tweets_sql = "SELECT * FROM tweets WHERE user_id = $user_id ORDER BY created_at DESC";
$tweets_result = $db->query($tweets_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetClone - Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #15202B;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .profile-info {
            background-color: #192734;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .tweet {
            background-color: #192734;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .tweet-date {
            color: #8899A6;
            font-size: 0.8rem;
        }
        .back-btn {
            background-color: #192734;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profile</h1>
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        </div>
        <div class="profile-info">
            <h2><?php echo $user['name']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Joined: <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
        </div>
        <h2>Your Tweets</h2>
        <?php while ($tweet = $tweets_result->fetch_assoc()): ?>
            <div class="tweet">
                <p><?php echo $tweet['content']; ?></p>
                <span class="tweet-date"><?php echo date('M d, Y H:i', strtotime($tweet['created_at'])); ?></span>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
