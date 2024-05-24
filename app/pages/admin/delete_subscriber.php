<?php
require_once '../app/core/connection.php'; // Adjust the path as necessary

if (isset($_GET['subscriber_id'])) {
    $subscripe_id = $_GET['subscriber_id'];
    $conn = get_connection();

    try {
        $stmt = $conn->prepare("DELETE FROM subscribers WHERE subscriber_id = ?");
        $stmt->execute([$subscripe_id]);
        
        header("Location: " . ROOT . "subscriptions.php"); // Redirect to comment management page
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Comment ID not provided!";
}
?>
