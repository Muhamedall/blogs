<?php

require_once '../app/core/connection.php'; 

// Start the session to access session variables


// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$conn = get_connection();
$user_id = $_SESSION['admin'];
$message = '';

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_picture'])) {
        $file = $_FILES['profile_picture'];
        $upload_dir = '../public/uploads/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        // Check if the file type is allowed
        if (!in_array($file['type'], $allowed_types)) {
            $message = 'Only JPG, PNG, and GIF files are allowed.';
        } else {
            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $message = 'Error uploading file.';
            } else {
                // Move the uploaded file to the desired directory
                $file_name = $user_id . '_' . time() . '_' . basename($file['name']);
                $file_path = $upload_dir . $file_name;

                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    // Update profile picture path in the database
                    $stmt = $conn->prepare("UPDATE admins SET profile_picture = :profile_picture WHERE admin_id = :admin_id");
                    $stmt->bindParam(':profile_picture', $file_path);
                    $stmt->bindParam(':admin_id', $user_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $message = 'Profile picture updated successfully.';
                    } else {
                        $message = 'Error updating profile picture in the database.';
                    }
                } else {
                    $message = 'Error moving uploaded file.';
                }
            }
        }
    } elseif (isset($_POST['delete_picture'])) {
        // Handle profile picture deletion
        $stmt = $conn->prepare("SELECT profile_picture FROM admins WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $profile_picture = $stmt->fetchColumn();

        if ($profile_picture && file_exists($profile_picture)) {
            unlink($profile_picture); // Delete the file from the server
        }

        $stmt = $conn->prepare("UPDATE admins SET profile_picture = NULL WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $message = 'Profile picture deleted successfully.';
        } else {
            $message = 'Error deleting profile picture in the database.';
        }
    }
}

// Fetch current profile picture
$stmt = $conn->prepare("SELECT profile_picture FROM admins WHERE admin_id = :admin_id");
$stmt->bindParam(':admin_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$profile_picture = $stmt->fetchColumn();
?>
