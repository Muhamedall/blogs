<?php

require_once '../app/core/connection.php';

function get_user_info($admin_id) {
    $conn = get_connection();
    try {
        $stmt = $conn->prepare("SELECT email FROM admins WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error retrieving user info: " . $e->getMessage();
    }
}

function update_email($admin_id, $email) {
    $conn = get_connection();
    try {
        $stmt = $conn->prepare("UPDATE admins SET email = :email WHERE admin_id = :admin_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error updating email: " . $e->getMessage();
        return false;
    }
}

function update_password($admin_id, $password) {
    $conn = get_connection();
    try {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE admins SET password = :password WHERE admin_id = :admin_id");
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error updating password: " . $e->getMessage();
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_SESSION['admin'];
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            update_email($admin_id, $email);
            echo "Email updated successfully.";
        } else {
            echo "Invalid email format.";
        }
    }

    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if ($password === $confirm_password) {
            update_password($admin_id, $password);
            echo "Password updated successfully.";
        } else {
            echo "Passwords do not match.";
        }
    }
}

$admin_id = $_SESSION['admin'];
$user_info = get_user_info($admin_id);
?>