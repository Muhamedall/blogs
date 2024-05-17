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
            // Category exists, return its ID
            return $result['category_id'];
        } else {
            // Category does not exist, insert it and return the new ID
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindParam(':name', $category_name);
            $stmt->execute();
            return $conn->lastInsertId();
        }
    } catch(PDOException $e) {
        // If an error occurs, display the error message
        echo "Error: " . $e->getMessage();
    }
}

// Function to handle file uploads
function upload_file($file) {
    // Define upload directory
    $upload_dir = '../public/uploads/';
    // Use the original filename
    $filename = basename($file['name']);
    // Move the uploaded file to the upload directory
    if (!move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
        // If move_uploaded_file fails, return false
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
    $category_name = trim($_POST["category"]); // Get selected category
    $image_or_video = $_FILES["image_or_video"]; // Get uploaded image or video file

    // Check if title, content, and category are not empty
    if (!empty($title) && !empty($content) && !empty($category_name)) {
        // Insert post into database
        try {
            $conn = get_connection();
            // Check if category exists, if not, insert it
            $category_id = get_or_insert_category_id($category_name);

            // Check if file was uploaded
            if ($image_or_video['error'] === UPLOAD_ERR_OK) {
                // Upload the file and get its path
                $file_path = upload_file($image_or_video);
                if ($file_path === false) {
                    // Handle file upload error
                    echo "Error uploading file.";
                    exit();
                }
            } else {
                // No file uploaded
                $file_path = null;
            }

            // Prepare and execute statement to insert post
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
            // Handle database error
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Handle validation errors
        echo "Title, content, and category are required!";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<form class="w-[40%] container mx-auto grid grid-rows-4" method="POST" enctype="multipart/form-data">
    <div class="mb-5">
        <label for="title" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Title</label>
        <input type="text" name="title" id="title" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
    </div>
    <div class="mb-5">
        <label for="content" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Content</label>
        <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description..."></textarea>
    </div>
    <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Category</label>
        <select id="category" name="category" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="travel">Triathlon</option>
            <option value="opinions">Opinions</option>
            <option value="stories">Stories</option>
            <option value="productivity">Productivity</option>
            <option value="experiences">Experiences</option>
        </select>
    </div>
    <div class="mb-5">
        <label for="image_or_video" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Upload Image or Video</label>
        <input type="file" name="image_or_video" id="image_or_video" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add Post</button>
</form>

<?php
function get_posts() {
    $conn = get_connection();
    
    try {
        $stmt = $conn->prepare("SELECT posts.post_id, posts.title, posts.content, posts.image_or_video_url, categories.name AS category_name FROM posts INNER JOIN categories ON posts.category_id = categories.category_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Retrieve posts
$posts = get_posts();
?>
<style>
    .description {
        width: 200px; /* Adjust as needed */
        word-wrap: break-word;
        white-space: pre-wrap; /* Preserves whitespace and breaks lines */
    }
</style>

<div class="container mx-auto   " > 
    <h1 class="text-2xl font-bold mb-4">Manage Posts</h1>
    <table class="min-w-[80%]   bordr border-2 bg-white ml-[10%]  ">
    <thead class="bg-white  bordr border-2 bg-white ">
      
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider">Title</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider">Category</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider">Description</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider">Image/Video</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white   bordr border-2 bg-white ">
        <?php foreach ($posts as $post): ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap "><?php echo $post['title']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo $post['category_name']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap description"><?php echo htmlspecialchars(substr($post['content'], 0, 50)); ?>.. </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if ($post['image_or_video_url']): ?>
                        <?php 
                            $file_path = $post['image_or_video_url']; 
                            $public_path = str_replace('../public', ROOT, $file_path);
                        ?>
                        <img src="<?php echo $public_path; ?>" alt="Post Image/Video" class="w-20 h-20 rounded-lg">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button class="text-indigo-400 hover:text-indigo-200">Edit</button>
                    <button class="text-red-400 hover:text-red-200 ml-4">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
