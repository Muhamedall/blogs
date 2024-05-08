<?php

// Function to establish a database connection
function get_connection() {
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=myblogs_db", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "";

        return $conn;
       
    } catch(PDOException $e) {
        // If connection fails, die and display error message
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to create database tables
function create_tables() {
    $conn = get_connection(); // Get database connection

    try {
        // Create tables
        $conn->exec("CREATE TABLE IF NOT EXISTS admins (
            admin_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL
        )");

        $conn->exec("CREATE TABLE IF NOT EXISTS posts (
            post_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            content TEXT NOT NULL,
            category_id INT NOT NULL,
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

        $conn->exec("CREATE TABLE IF NOT EXISTS categories (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL
        )");

        echo "";
    } catch(PDOException $e) {
        // If an error occurs, display the error message
        echo "Error creating tables: " . $e->getMessage();
    }
}

// Call the function to create tables
create_tables();

// Function to display existing tables
// Function to display existing tables
function display_tables() {
    $conn = get_connection(); // Get database connection

   
}
// Function to display attributes of existing tables

// Call the function to display tables
display_tables();

?>
