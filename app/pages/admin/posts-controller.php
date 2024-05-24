<?php

require_once "../app/core/connection.php";


// Function to retrieve category ID by name or insert if not exists
function get_or_insert_category_id($category_name) {
    $conn = get_connection();
    
    try {
        // Check if the category already exists
        $stmt = $conn->prepare("SELECT category_id FROM categories WHERE name = :name");
        $stmt->bindParam(':name', $category_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['category_id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindParam(':name', $category_name);
            $stmt->execute();
            return $conn->lastInsertId();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to handle file uploads
function upload_file($file) {
    // Define upload directory
    $upload_dir = '../public/uploads/';
    // Use the original filename
    $filename = basename($file['name']);
  
    if (!move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
        return false;
    }
    // Return the file path
    return $upload_dir . $filename;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $category_name = trim($_POST["category"]); 
    $image_or_video = $_FILES["image_or_video"]; 

    if (!empty($title) && !empty($content) && !empty($category_name)) {
   
        try {
            $conn = get_connection();
            
            $category_id = get_or_insert_category_id($category_name);

            // Check if file was uploaded
            if ($image_or_video['error'] === UPLOAD_ERR_OK) {
                $file_path = upload_file($image_or_video);
                if ($file_path === false) {
                    // Handle file upload error
                    echo "Error uploading file.";
                    exit();
                }
            } else {
                $file_path = null;
            }

            $stmt = $conn->prepare("INSERT INTO posts (title, content, category_id, image_or_video_url) VALUES (:title, :content, :category_id, :image_or_video_url)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':image_or_video_url', $file_path, PDO::PARAM_STR);
            $stmt->execute();
            
            // Redirect after successful insertion
            header("Location: " . ROOT . "/admin");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Title, content, and category are required!";
    }
}
?>