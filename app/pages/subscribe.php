<?php
require_once "../app/core/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $conn = get_connection();
            
            // Check if email already exists in the database
            $stmt_check = $conn->prepare("SELECT * FROM subscribers WHERE email = :email");
            $stmt_check->bindParam(':email', $email);
            $stmt_check->execute();
            $existing_email = $stmt_check->fetch();

            if ($existing_email) {
                // If email already exists, return error
                echo json_encode(['error' => 'duplicate_email']);
                exit();
            } else {
                // If email doesn't exist, insert into the database
                $stmt_insert = $conn->prepare("INSERT INTO subscribers (email) VALUES (:email)");
                $stmt_insert->bindParam(':email', $email);
                $stmt_insert->execute();
                echo json_encode(['success' => true]);
                exit();
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Invalid email format']);
        exit();
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>
