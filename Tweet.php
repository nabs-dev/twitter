<?php
class Tweet {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($user_id, $content) {
        $content = $this->db->real_escape_string($content);
        $sql = "INSERT INTO tweets (user_id, content) VALUES ('$user_id', '$content')";
        return $this->db->query($sql);
    }

    public function getAll() {
        $sql = "SELECT t.id, t.content, t.created_at, u.name, 
                (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) as like_count
                FROM tweets t
                JOIN users u ON t.user_id = u.id
                ORDER BY t.created_at DESC";
        return $this->db->query($sql);
    }

    public function like($user_id, $tweet_id) {
        $sql = "INSERT INTO likes (user_id, tweet_id) VALUES ('$user_id', '$tweet_id')
                ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP";
        return $this->db->query($sql);
    }

    public function getLikes($tweet_id) {
        $sql = "SELECT COUNT(*) as count FROM likes WHERE tweet_id = '$tweet_id'";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}
?>
