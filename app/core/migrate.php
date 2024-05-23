<?php
require_once "../app/core/connection.php";

function migrate() {
    $conn = get_connection();

    try {
        // Drop tables if they exist
        $conn->exec("DROP TABLE IF EXISTS visitors");
        $conn->exec("DROP TABLE IF EXISTS subscribers");
        $conn->exec("DROP TABLE IF EXISTS comments");
        $conn->exec("DROP TABLE IF EXISTS posts");
        $conn->exec("DROP TABLE IF EXISTS categories");
        $conn->exec("DROP TABLE IF EXISTS admins");

        // Create tables
        $conn->exec("CREATE TABLE IF NOT EXISTS admins (
            admin_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS categories (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS posts (
            post_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            content TEXT NOT NULL,
            category_id INT NOT NULL,
            image_or_video_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS comments (
            comment_id INT AUTO_INCREMENT PRIMARY KEY,
            post_id INT NOT NULL,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            comment TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS subscribers (
            subscriber_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS visitors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            visit_date DATE NOT NULL
        )");

        echo "Migration completed successfully.";

    } catch(PDOException $e) {
        echo "Error during migration: " . $e->getMessage();
    }
}

// Run migration
migrate();
?>
