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
    .description , .title {
        width: 200px; /* Adjust as needed */
        word-wrap: break-word;
        white-space: pre-wrap; /* Preserves whitespace and breaks lines */
    }
</style>

<div class="container mt-[7%] ml-[5%]">
    <div class="flex flex-row">
        <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Manage</h1>
        <span class="text-xl font-bold mt-2"> Posts</span>
    </div>
    <table class="border border-2 w-[90%] mt-[3%]">
        <thead class="bg-white border border-2 bg-[#DFF1F0] dark:bg-gray-600">
            <tr>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Title</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Category</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Description</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Image/Video</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-[#F2F8F7] border border-2 bg-white dark:bg-gray-600">
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap title dark:text-white"><?php echo $post['title']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-slate-950">
                        <span class="bg-[#DFF1F0] rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold"><?php echo $post['category_name']; ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap description dark:text-white"><?php echo htmlspecialchars(substr($post['content'], 0, 50)); ?>..</td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white">
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
                    <td class="px-6 py-4 flex flex-row gap-4">
                        <a href="<?=ROOT?>/admin/edit_post?post_id=<?php echo $post['post_id']; ?>" class="btn-edit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#78A75A"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></a>
                        <a href="<?=ROOT?>/admin/delete_post?post_id=<?php echo $post['post_id']; ?>" class="btn-delete"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

