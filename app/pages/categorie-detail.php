<?php
require_once "../app/core/connection.php";
$conn = get_connection();

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch category details
    $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
    $category_stmt->bindParam(':category_id', $category_id);
    $category_stmt->execute();
    $category = $category_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "Category not found.";
        exit;
    }

    // Fetch posts in this category
    $posts_stmt = $conn->prepare("SELECT post_id, title, content, image_or_video_url, created_at FROM posts WHERE category_id = :category_id ORDER BY created_at DESC");
    $posts_stmt->bindParam(':category_id', $category_id);
    $posts_stmt->execute();
    $posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Category ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2F8F7]">
    <header>
        <?php include "header.php"; ?>
    </header>

    <main class="container mx-auto px-4 mt-8">
        <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($category['name']); ?></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 ">
            <?php foreach ($posts as $post) { ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden ">
                    <a href="fetch_post_details?post_id=<?php echo $post['post_id']; ?>">
                        <?php if ($post['image_or_video_url']) { ?>
                            <img src="<?php echo htmlspecialchars($post['image_or_video_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-48 object-cover">
                        <?php } ?>
                        <div class="p-4">
                            <h2 class="font-bold text-xl mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p class="text-gray-700 text-base">
                                <?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?>
                            </p>
                            <p class="text-gray-500 text-sm mt-2"><?php echo date("F j, Y", strtotime($post['created_at'])); ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </main>

    <footer class="mt-16">
        <?php include "footer.php"; ?>
    </footer>
</body>
</html>
