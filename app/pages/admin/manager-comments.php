<?php
require_once '../app/core/connection.php';

function get_comments() {
    $conn = get_connection();
    
    try {
        $stmt = $conn->prepare("SELECT comments.comment_id, comments.comment AS content, comments.post_id, comments.name AS user_name, posts.title AS post_title FROM comments INNER JOIN posts ON comments.post_id = posts.post_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Retrieve comments
$comments = get_comments();
?>