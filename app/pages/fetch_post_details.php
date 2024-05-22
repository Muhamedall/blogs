
<?php

require_once "../app/core/connection.php";
include '../app/pages/header.php';

// Check if post ID is provided via GET request
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $conn = get_connection();
    if (!$conn) {
        echo "Database connection error";
        exit;
    }

    // Fetch post details
    $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = :post_id");
    $stmt->bindParam(':post_id', $post_id);
    if (!$stmt->execute()) {
        echo "Error executing query";
        exit;
    }

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Handle comment submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $_POST['comment'];

            $comment_stmt = $conn->prepare("INSERT INTO comments (post_id, name, email, comment) VALUES (:post_id, :name, :email, :comment)");
            $comment_stmt->bindParam(':post_id', $post_id);
            $comment_stmt->bindParam(':name', $name);
            $comment_stmt->bindParam(':email', $email);
            $comment_stmt->bindParam(':comment', $comment);
            $comment_stmt->execute();
        }

        // Fetch comments
        $comments_stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC");
        $comments_stmt->bindParam(':post_id', $post_id);
        $comments_stmt->execute();
        $comments = $comments_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body> 
    <section class="flex flex-row">
        <div>
            <h1><?php echo $post['title']; ?></h1>
            <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-2xl p-3 h-[400px] w-[420px]">
            <?php 
            $category_id = $post['category_id'];
            $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
            $category_stmt->bindParam(':category_id', $category_id);
            $category_stmt->execute();
            $category_name = $category_stmt->fetchColumn();
            ?>
            <span class="bg-[#DFF1F0] rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold mb-5 ml-[10px]">
                <?php echo $category_name; ?>
            </span>
        </div>
        <div>
            <p><?php echo $post['content']; ?></p>
        </div>
    </section>
   
    <div class="min-h-screen flex items-center justify-center">
        <div class="px-10">
            <div class="bg-white max-w-xl rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                <div class="w-14 h-14 bg-yellow-500 rounded-full flex items-center justify-center font-bold text-white">LOGO</div>
                <div class="mt-4">
                    <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">Comments</h1>
                    <div class="mt-4">
                        <?php foreach ($comments as $comment) { ?>
                            <div class="bg-gray-100 rounded-lg p-4 mt-4">
                                <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong> (<?php echo htmlspecialchars($comment['email']); ?>) said:</p>
                                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                <p class="text-xs text-gray-500">Posted on <?php echo $comment['created_at']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="p-6 bg-yellow-400 rounded-full h-12 w-12 flex items-center justify-center text-2xl text-white mt-4 shadow-lg cursor-pointer" onclick="toggleCommentForm()">+</div>
                    </div>
                    <div id="commentForm" class="hidden mt-6">
                        <h2 class="text-lg font-semibold">Add a Comment</h2>
                        <form action="" method="post" class="mt-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                            <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <label for="email" class="block text-sm font-medium text-gray-700 mt-4">Email:</label>
                            <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mt-4">Comment:</label>
                            <textarea id="comment" name="comment" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            <input type="submit" name="submit_comment" value="Submit Comment" class="mt-4 bg-yellow-500 text-white py-2 px-4 rounded-md shadow-lg hover:bg-yellow-600">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleCommentForm() {
            const commentForm = document.getElementById('commentForm');
            commentForm.classList.toggle('hidden');
        }
    </script>
</body>
</html>

<?php
    } else {
        echo "Post not found";
    }
} else {
    echo "Post ID not provided";
}
?>

<footer>
    <?php include "footer.php"; ?>
</footer>
