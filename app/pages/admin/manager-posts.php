<?php

$conn = get_connection();
$stmt = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sqlcategories=$conn->query("SELECT * FROM  categories");
$categories =$sqlcategories->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
<h1>Managementne Posts</h1>
<table class="mt-4 w-full min-w-max table-auto text-left">
    <thead>
        <tr>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">ID</th>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Category</th>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Title</th>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Image</th>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Created At</th>
            <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) : ?>
            
            <tr>
                <td class="p-4 border-b border-blue-gray-50"><?php echo $post['post_id']; ?></td>
                <td class="p-4 border-b border-blue-gray-50">
                <?php
    $category_name = "";
    foreach ($categories as $category) {
        if ($category['category_id'] == $post['category_id']) {
            $category_name = $category['name'];
            break;
        }
    }
    echo $category_name;
    ?>
                </td>
                <td class="p-4 border-b border-blue-gray-50"><?php echo $post['title']; ?></td>
                <td class="p-4 border-b border-blue-gray-50">
               
               
            


   
                <img src="<?php echo $post['image_or_video_url']; ?>" alt="Post Image" class="rounded-lg p-3 h-[200px] w-[300px]">




                </td>
                <td class="p-4 border-b border-blue-gray-50"><?php echo date("F j, Y", strtotime($post['created_at'])); ?></td>
                <td class="p-4 border-b border-blue-gray-50">
                  
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">Edit</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
      
    </tbody>
</table>


</div>
