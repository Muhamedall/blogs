
<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com"> <!-- Ensure Tailwind CSS is included -->
    <style>
        .description, .title {
            width: 200px; /* Adjust as needed */
            word-wrap: break-word;
            white-space: pre-wrap; /* Preserves whitespace and breaks lines */
        }
    </style>
</head>
<body>
<div class="container mt-[7%] ml-[5%]">
    <div class="flex flex-row">
        <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Manage</h1><span class="text-xl font-bold mt-2"> Comments</span>
    </div>
    <table class="border border-2 w-[90%] mt-[3%]">
        <thead class="bg-white border border-2 bg-[#DFF1F0] dark:bg-gray-600">
            <tr>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Content</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Post</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">User</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-[#F2F8F7] border border-2 bg-white dark:bg-gray-600">
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap description dark:text-white"><?php echo htmlspecialchars(substr($comment['content'], 0, 50)); ?>...</td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars($comment['post_title']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars($comment['user_name']); ?></td>
                    <td class="px-6 py-4 flex flex-row gap-4">
                        
                        <a href="<?=ROOT?>/admin/delete_comment?comment_id=<?php echo $comment['comment_id']; ?>" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
