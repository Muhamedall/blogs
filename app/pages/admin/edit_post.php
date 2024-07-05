<?php
require_once '../app/core/connection.php'; 
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $conn = get_connection();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category_id = $_POST['category'];
        
        // Check if a new file is uploaded
        if (isset($_FILES['image_or_video']) && $_FILES['image_or_video']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../public/uploads/";
            $target_file = $target_dir . basename($_FILES["image_or_video"]["name"]);
            if (move_uploaded_file($_FILES["image_or_video"]["tmp_name"], $target_file)) {
                $image_or_video_url = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                $image_or_video_url = $post['image_or_video_url']; // Keep old URL if new upload fails
            }
        } else {
            $image_or_video_url = $post['image_or_video_url']; // Keep old URL if no new file is uploaded
        }

        try {
            $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, category_id = ?, image_or_video_url = ? WHERE post_id = ?");
            $stmt->execute([$title, $content, $category_id, $image_or_video_url, $post_id]);
            header("Location: admin_posts.php"); // Redirect to admin post management page
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    try {
        $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com"> <!-- Ensure Tailwind CSS is included -->
</head>
<body>
    <h1>Edit Post</h1>
    <form class="w-[40%] ml-[5%] mt-[20px] container grid grid-cols-2 gap-4" method="POST" enctype="multipart/form-data">
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Title</label>
            <input type="text" name="title" id="title" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title" value="<?php echo htmlspecialchars($post['title']); ?>">
        </div>
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Category</label>
            <select id="category" name="category" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="1" <?php if ($post['category_id'] == 1) echo 'selected'; ?>>Triathlon</option>
                <option value="2" <?php if ($post['category_id'] == 2) echo 'selected'; ?>>Opinions</option>
                <option value="3" <?php if ($post['category_id'] == 3) echo 'selected'; ?>>Stories</option>
                <option value="4" <?php if ($post['category_id'] == 4) echo 'selected'; ?>>Productivity</option>
                <option value="5" <?php if ($post['category_id'] == 5) echo 'selected'; ?>>Experiences</option>
            </select>
        </div>
        <div class="mb-5 col-span-2">
            <label for="image_or_video" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Upload Image or Video</label>
            <input type="file" name="image_or_video" id="image_or_video" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <?php if ($post['image_or_video_url']): ?>
                <p>Current file: <?php echo basename($post['image_or_video_url']); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-5 col-span-2">
            <label for="content" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Content</label>
            <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-[#00AAA1] focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description..."><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <button type="submit" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded">Update Post</button>
    </form>
</body>
</html>
