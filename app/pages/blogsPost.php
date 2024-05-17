<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body>
    <!-- Blog Section Start -->
    <section class="mt-[2%]">
        <div class="container mx-auto">
            <div class="flex flex-wrap -mx-4">
                <?php
                // Fetch posts from the database
                require_once "../app/core/connection.php";
                $conn = get_connection();
                $stmt = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through each postz
                foreach ($posts as $post) {
                    $category_id = $post['category_id'];
                    $category_stmt = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
                    $category_stmt->bindParam(':category_id', $category_id);
                    $category_stmt->execute();
                    $category_name = $category_stmt->fetchColumn();

                    // Output HTML for each post
                    ?>
                    <div class="w-full md:w-1/2 lg:w-1/3 px-4 border ">
                        <div class="max-w-[370px] mx-auto mb-10">
                            <div class="rounded overflow-hidden ">
                                
                                <div class="">
                                <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-lg p-3 h-[200px] w-[300px]">
                                <span class="bg-[#DFF1F0] rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold mb-5 ml-[10px] ">
                                    <?php echo $category_name; ?>
                                </span>
                                </div>
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
                                <span class="  rounded  py-1 px-4 text-xs  text-slate-950  mr-[4px]">
                                    <?php echo date("F j, Y", strtotime($post['created_at'])); ?>
                                </span>
                            </div>
                            
                            
                           
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
</body>
</html>
