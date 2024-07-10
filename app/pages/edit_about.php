<?php

require_once "../app/core/connection.php";

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Unauthorized access.");
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $about_content = $_POST['about_content'];
    $team_content = $_POST['team_content'];
    $mission_content = $_POST['mission_content'];
    $join_content = $_POST['join_content'];

    // Validate form data (you can add more validation as needed)
    if (empty($about_content) || empty($team_content) || empty($mission_content) || empty($join_content)) {
        die("All fields are required.");
    }

    // Update the content in the database
    $sql = "UPDATE about_us SET about_content = ?, team_content = ?, mission_content = ?, join_content = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $about_content, $team_content, $mission_content, $join_content);

    if ($stmt->execute()) {
        echo "Content updated successfully.";
    } else {
        echo "Error updating content: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request.");
}
?>
