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
<body class="bg-gray-50">
    <section class="flex flex-col lg:flex-row mt-8 px-4 lg:px-20">
        <div class="lg:w-2/3">
            <h1 class="font-bold text-4xl mb-6"><?php echo $post['title']; ?></h1>
            <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-2xl p-3 w-full h-auto">
            <?php 
            $category_id = $post['category_id'];
            $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
            $category_stmt->bindParam(':category_id', $category_id);
            $category_stmt->execute();
            $category_name = $category_stmt->fetchColumn();
            ?>
            <div class="flex items-center mt-4">
                <span class="bg-[#DFF1F0] rounded text-xs font-semibold py-1 px-4 mr-2"><?php echo $category_name; ?></span>
                <span class="text-xs text-gray-500"><?php echo date("F j, Y", strtotime($post['created_at'])); ?></span>
            </div>
            <div class="share-post mt-4 ">
                <button onclick="toggleShareOptions()" >                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M720-80q-50 0-85-35t-35-85q0-7 1-14.5t3-13.5L322-392q-17 15-38 23.5t-44 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q23 0 44 8.5t38 23.5l282-164q-2-6-3-13.5t-1-14.5q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-23 0-44-8.5T638-672L356-508q2 6 3 13.5t1 14.5q0 7-1 14.5t-3 13.5l282 164q17-15 38-23.5t44-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-640q17 0 28.5-11.5T760-760q0-17-11.5-28.5T720-800q-17 0-28.5 11.5T680-760q0 17 11.5 28.5T720-720ZM240-440q17 0 28.5-11.5T280-480q0-17-11.5-28.5T240-520q-17 0-28.5 11.5T200-480q0 17 11.5 28.5T240-440Zm480 280q17 0 28.5-11.5T760-200q0-17-11.5-28.5T720-240q-17 0-28.5 11.5T680-200q0 17 11.5 28.5T720-160Zm0-600ZM240-480Zm480 280Z"/></svg>
                </button>
                <div id="shareOptions" class="  hidden mt-2 ">
                
            
                <svg onclick="sharePost('facebook')"  xmlns="http://www.w3.org/2000/svg" class="w-[10%] h-[10%] lg:w-[3%] lg:h-[5%] cursor-pointer  "  viewBox="0 0 50 50" fill="#00AAA1">
    <path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z"></path>
</svg>            
                
                <svg onclick="sharePost('linkedin')" xmlns="http://www.w3.org/2000/svg" class="w-[10%] h-[10%] lg:w-[3%] lg:h-[5%] cursor-pointer " viewBox="0 0 50 50" fill="#00AAA1">
    <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z"></path>
</svg>                
    
                <svg  onclick="sharePost('instagram')" xmlns="http://www.w3.org/2000/svg" class="w-[10%] h-[10%] lg:w-[3%] lg:h-[5%] cursor-pointer " viewBox="0 0 30 30" fill="#00AAA1">
    <path d="M 9.9980469 3 C 6.1390469 3 3 6.1419531 3 10.001953 L 3 20.001953 C 3 23.860953 6.1419531 27 10.001953 27 L 20.001953 27 C 23.860953 27 27 23.858047 27 19.998047 L 27 9.9980469 C 27 6.1390469 23.858047 3 19.998047 3 L 9.9980469 3 z M 22 7 C 22.552 7 23 7.448 23 8 C 23 8.552 22.552 9 22 9 C 21.448 9 21 8.552 21 8 C 21 7.448 21.448 7 22 7 z M 15 9 C 18.309 9 21 11.691 21 15 C 21 18.309 18.309 21 15 21 C 11.691 21 9 18.309 9 15 C 9 11.691 11.691 9 15 9 z M 15 11 A 4 4 0 0 0 11 15 A 4 4 0 0 0 15 19 A 4 4 0 0 0 19 15 A 4 4 0 0 0 15 11 z"></path>
</svg>
               
        
                </div>
            </div>
            <div class="mt-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h1 class="text-lg font-semibold mb-4">Comments</h1>
                    <div class="space-y-4">
                        <?php foreach ($comments as $comment) { ?>
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong></p>
                                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                <p class="text-xs text-gray-500">Posted on <?php echo date("F j, Y", strtotime($comment['created_at'])); ?></p>
                                <?php
                                $replies_stmt->bindParam(':comment_id', $comment['comment_id']);
                                $replies_stmt->execute();
                                $replies = $replies_stmt->fetchAll(PDO::FETCH_ASSOC);
                                if ($replies) {
                                    foreach ($replies as $reply) { ?>
                                        <div class="bg-gray-200 p-4 rounded-lg mt-2 ml-6">
                                            <p><strong><?php echo htmlspecialchars($reply['reply']); ?></strong></p>
                                            <?php if ($is_admin) { ?>
                                                <button class="text-blue-500">Edit</button>
                                                <button class="text-red-500">Delete</button>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                }
                                ?>
                                <?php if ($is_admin) { ?>
                                    <div class="mt-2">
                                        <form action="" method="post">
                                            <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                            <textarea name="reply_comment" placeholder="Reply..." class="w-full p-2 border rounded"></textarea>
                                            <button type="submit" name="submit_reply" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Reply</button>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="flex justify-center mt-6">
                        <div class="bg-[#00AAA1] rounded-full h-12 w-12 flex items-center justify-center text-2xl text-white shadow-lg cursor-pointer" onclick="toggleCommentForm()">+</div>
                    </div>
                    <div id="commentForm" class="hidden mt-6">
                        <h2 class="text-lg font-semibold mb-4">Add a Comment</h2>
                        <form action="" method="post" class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                                <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                                <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700">Comment:</label>
                                <textarea id="comment" name="comment" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                            <input type="submit" name="submit_comment" value="Submit Comment" class="bg-[#00AAA1] text-white py-2 px-4 rounded-md shadow-lg hover:bg-[#008080]">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:w-1/3 mt-8 lg:mt-0 lg:ml-8">
            <p class="text-lg font-medium"><?php echo nl2br($post['content']); ?></p>
        </div>
    </section>

    <script>
        function toggleCommentForm() {
            const commentForm = document.getElementById('commentForm');
            commentForm.classList.toggle('hidden');
        }

        function toggleShareOptions() {
            const shareOptions = document.getElementById('shareOptions');
            shareOptions.classList.toggle('hidden');
        }

        function sharePost(platform) {
            const postUrl = encodeURIComponent(window.location.href);
            const postTitle = encodeURIComponent("<?php echo $post['title']; ?>");

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${postUrl}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${postUrl}&title=${postTitle}`;
                    break;
                case 'instagram':
                    alert('Instagram sharing is not supported via web. Please share this post directly from your Instagram app.');
                    return;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
</body>
</html>

<?php
    } else {
        echo "Post not found.";
    }
    $conn = null;
} else {
    echo "Invalid request.";
}
include '../app/pages/footer.php';
?>
