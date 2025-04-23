<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $db->real_escape_string($_POST['content']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO tweets (user_id, content) VALUES ('$user_id', '$content')";
    $db->query($sql);
}

$sql = "SELECT t.id, t.content, t.created_at, u.name, 
        (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) as like_count
        FROM tweets t
        JOIN users u ON t.user_id = u.id
        ORDER BY t.created_at DESC";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetClone - Dashboard</title>
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
        .tweet-form {
            background-color: #192734;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .tweet-form textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #253341;
            color: #ffffff;
            resize: none;
        }
        .tweet-form button {
            background-color: #1DA1F2;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .tweet {
            background-color: #192734;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .tweet-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .tweet-name {
            font-weight: bold;
        }
        .tweet-date {
            color: #8899A6;
        }
        .tweet-content {
            margin-bottom: 0.5rem;
        }
        .tweet-actions {
            display: flex;
            justify-content: space-between;
        }
        .like-btn {
            background: none;
            border: none;
            color: #1DA1F2;
            cursor: pointer;
        }
        .logout-btn {
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
            <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <div class="tweet-form">
            <form method="POST" action="">
                <textarea name="content" placeholder="What's happening?" maxlength="280" required></textarea>
                <button type="submit">Tweet</button>
            </form>
        </div>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="tweet">
                <div class="tweet-header">
                    <span class="tweet-name"><?php echo $row['name']; ?></span>
                    <span class="tweet-date"><?php echo date('M d', strtotime($row['created_at'])); ?></span>
                </div>
                <div class="tweet-content"><?php echo $row['content']; ?></div>
                <div class="tweet-actions">
                    <button class="like-btn" onclick="likeTweet(<?php echo $row['id']; ?>)">
                        ❤️ <span id="like-count-<?php echo $row['id']; ?>"><?php echo $row['like_count']; ?></span>
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <script>
        function likeTweet(tweetId) {
            fetch('like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'tweet_id=' + tweetId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('like-count-' + tweetId).textContent = data.likes;
                }
                    document.getElementById('like-count-' + tweetId).textContent = data.likes;
                }
            });
        }
    </script>
</body>
</html>
