<?php
require_once "../app/core/connection.php";
$conn = get_connection();
$stmt = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Chunk the posts array into chunks of 4 posts per slide
$postsChunks = array_chunk($posts, 4);

// Determine the total number of slides
$totalSlides = count($postsChunks);
// Get the current page number
$currentSlide = isset($_GET['slide']) ? $_GET['slide'] : 1;
// Validate the current page number
if ($currentSlide < 1 || $currentSlide > $totalSlides) {
    $currentSlide = 1; // Default to the first slide if the page number is out of range
}

// Calculate the previous and next slide numbers
$prevSlide = $currentSlide - 1;
$nextSlide = $currentSlide + 1;
// Disable previous and next buttons if they are not applicable
$prevDisabled = ($prevSlide < 1) ? "disabled" : "";
$nextDisabled = ($nextSlide > $totalSlides) ? "disabled" : "";

// Get the posts for the current slide
$currentPosts = $postsChunks[$currentSlide - 1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    


<div class="flex flex-wrap -mx-4">
    <?php foreach ($currentPosts as $post) {
        $category_id = $post['category_id'];
        $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
        $category_stmt->bindParam(':category_id', $category_id);
        $category_stmt->execute();
        $category_name = $category_stmt->fetchColumn();
    ?>
   <div class="w-full md:w-1/2 lg:w-1/4 px-4 drop-shadow-2xl">
    <div class="max-w-[370px] mx-auto mb-10">
        <div class="rounded overflow-hidden">
            <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-2xl p-3 h-[300px] w-[320px]">
            <span class="bg-[#DFF1F0] rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold mb-5 ml-[10px]">
                <?php echo $category_name; ?>
            </span>
        </div>
        <div class="ml-[4%]">
            <h3>
                <a href="#" class="font-semibold text-xl sm:text-2xl lg:text-4xl xl:text-4xl mb-2 inline-block text-dark hover:text-primary">
                    <?php echo $post['title']; ?>
                </a>
            </h3>
            <p class="text-base text-body-color">
                <?php echo $post['content']; ?>
            </p>
            <span class="rounded py-1 px-4 text-xs text-slate-950 mr-[4px]">
                <?php echo date("F j, Y", strtotime($post['created_at'])); ?>
            </span>
            <!-- Add a unique ID to each button -->
            <button class="details-btn" data-post-id="<?php echo $post['post_id']; ?>" onclick="showPostDetails(<?php echo $post['post_id']; ?>)">Details</button>
        </div>
    </div>
</div>
</body>

    <?php } ?>
    <script>
function showPostDetails(postId) {
    window.location.href = 'fetch_post_details?post_id=' + postId;
}
</script>






    </html>
    

<!-- Previous and next buttons -->

