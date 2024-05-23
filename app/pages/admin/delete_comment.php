<?php
require_once '../app/core/connection.php'; // Adjust the path as necessary

if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
    $conn = get_connection();

    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
        
        header("Location: " . ROOT . "/comments.php"); // Redirect to comment management page
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Comment ID not provided!";
}
?>
