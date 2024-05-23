<?php
function get_connection() {
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=myblogs_db", $username, $password);
     
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
       
    } catch(PDOException $e) {
       
        die("Connection failed: " . $e->getMessage());
    }
}
function get_today_posts_count($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_today_visitors_count($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM visitors WHERE visit_date = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_new_subscribers_count($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM subscribers WHERE DATE(subscribed_at) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function create_tables() {
    $conn = get_connection(); 

    try {
       
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
        
    } catch(PDOException $e) {
       
        echo "Error creating tables: " . $e->getMessage();
    }
}


create_tables();


function display_tables() {
    $conn = get_connection();

    try {
        
        $query = "SELECT table_name FROM information_schema.tables WHERE table_schema = :dbname";
        
       
        $stmt = $conn->prepare($query);
        
       
        $stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
        
      
        $dbname = "myblogs_db"; 
        
       
        $stmt->execute();
        
        
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

       
        echo "";
      
    } catch(PDOException $e) {
      
        echo "Error displaying tables: " . $e->getMessage();
    }
}


display_tables();

?>
