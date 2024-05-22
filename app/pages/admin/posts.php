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

 <body class="">
    
<script src="https://cdn.tailwindcss.com "></script>
<div class="flex flex-row  ">
    <h1 class="bg-[#00AAA1] ml-[5%]   text-[#FFFFFF] font-bold text-2xl">Create  </h1><span class="  text-xl font-bold mt-2"> Posts<span>
</div>
<form class="w-[40%]  ml-[5%] mt-[20px] container grid grid-cols-2 gap-4" method="POST" enctype="multipart/form-data">

    <div class="mb-5">
        <label for="title" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Title</label>
        <input type="text" name="title" id="title" class="block w-full  p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
    </div>
    <div class="mb-5 ">
        <label for="category" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Category</label>
        <select id="category" name="category" class=" block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="travel">Triathlon</option>
            <option value="opinions">Opinions</option>
            <option value="stories">Stories</option>
            <option value="productivity">Productivity</option>
            <option value="experiences">Experiences</option>
        </select>
        
    </div>
    <div class="mb-5 col-span-2">
        <label for="image_or_video" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Upload Image or Video</label>
        <input type="file" name="image_or_video" id="image_or_video" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
    <div class="mb-5 col-span-2 ">
        <label for="content" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Content</label>
        <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-[#00AAA1]  focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description..."></textarea>
    </div>
   
  
    <button type="submit" class="bg-[#00AAA1]  text-white font-bold py-2 px-4 rounded">Add Post</button>
</form>

<?php include '../app/pages/admin/manager-posts.php';?>
</body>

