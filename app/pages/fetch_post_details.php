<?php
require_once "../app/core/connection.php";
include '../app/pages/header.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $conn = get_connection();
    if (!$conn) {
        echo "Database connection error";
        exit;
    }

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
    $is_admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

    $replies_stmt = $conn->prepare("SELECT * FROM replies WHERE comment_id = :comment_id");

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_reply'])) {
        $reply_comment = $_POST['reply_comment'];
        $comment_id = $_POST['comment_id'];

        $reply_stmt = $conn->prepare("INSERT INTO replies (comment_id, reply) VALUES (:comment_id, :reply)");
        $reply_stmt->bindParam(':comment_id', $comment_id);
        $reply_stmt->bindParam(':reply', $reply_comment);
        $reply_stmt->execute();
    }

    $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = :post_id");
    $stmt->bindParam(':post_id', $post_id);
    if (!$stmt->execute()) {
        echo "Error executing query";
        exit;
    }

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
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
    <section class="flex flex-row mt-[3%]">
        <div class="">
            <h1 class="font-bold text-4xl ml-[12%]"><?php echo $post['title']; ?></h1>
            <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-2xl p-3 h-[400px] w-[420px] ml-[10%]">
            <?php 
            $category_id = $post['category_id'];
            $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
            $category_stmt->bindParam(':category_id', $category_id);
            $category_stmt->execute();
            $category_name = $category_stmt->fetchColumn();
            ?>
            <span class="bg-[#DFF1F0] ml-[12%] rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold mb-5">
                <?php echo $category_name; ?>
            </span>
            <span class="rounded py-1 px-4 text-xs text-slate-950 mr-[4px]">
                <?php echo date("F j, Y", strtotime($post['created_at'])); ?>
            </span>
            <div class="flex items-center justify-center ">
                <div class=" p-[10%] ">
                    <div class="bg-wight w-[400%] h-[100%]  p-[5%]  rounded-2xl  shadow-lg hover:shadow-2xl transition duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>
                        <div class="mt-4">
                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">Comments</h1>
                            <div class="mt-4 w-[100%] h-[80%]">
                                <?php foreach ($comments as $comment) { ?>
                                    <div class="bg-gray-100 rounded-lg w-[100%] h-[250%] px-20 p-6 mt-4">
                                        <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong> </p>
                                        <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                        <p class="text-xs text-gray-500">Posted on <?php echo date("F j, Y", strtotime($comment['created_at'])); ?></p>
                                    
                                        <?php
                                        $replies_stmt->bindParam(':comment_id', $comment['comment_id']);
                                        $replies_stmt->execute();
                                        $replies = $replies_stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if ($replies) {
                                            foreach ($replies as $reply) { ?>
                                                <div class="bg-gray-100 rounded-lg w-[100%] h-[250%] ml-[15%] ">
                                                    <p><strong><?php echo htmlspecialchars($reply['reply']); ?></strong> </p>

                                                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) { ?>

                                                    <button>edit ryplay</button>
                                                    <button>Suprime ryplay</button>
                                                    <?php } ?>

                                                    
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) { ?>
                                            <div class="mt-2">
                                                <form action="" method="post">
                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                    <textarea name="reply_comment" placeholder="Reply..."></textarea>
                                                    <button type="submit" name="submit_reply" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Reply</button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="p-6 bg-[#00AAA1] rounded-full h-12 w-12 flex items-center justify-center text-2xl text-white mt-4 shadow-lg cursor-pointer" onclick="toggleCommentForm()">+</div>
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
                                    <input type="submit" name="submit_comment" value="Submit Comment" class="mt-4 bg-[#DFF1F0] text-slate-950 py-2 px-4 rounded-md shadow-lg hover:bg-[#00AAA1]">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p class="lg:mt-[50%] lg:ml-[2%] text-lg font-medium"><?php echo $post['content']; ?></p>
        </div>
    </section>

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

<footer class="mt-[5%]">
    <?php include "footer.php"; ?>
</footer>
