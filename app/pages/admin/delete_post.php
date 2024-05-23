<?php
require_once '../app/core/connection.php'; 
require_once '../app/core/config.php';
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $conn = get_connection();

    try {
        $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        
        header("Location: " . ROOT . "posts"); 
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided!";
}
?>
