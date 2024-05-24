<?php
require_once '../app/core/connection.php';

function get_subscriptions() {
    $conn = get_connection();
    
    try {
        $stmt = $conn->prepare("SELECT subscribers.subscriber_id, subscribers.email, subscribers.subscribed_at  FROM  subscribers");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Retrieve subscribers
$subscribers=get_subscriptions();




?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Subscriptions</title>
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
        <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Manage</h1><span class="text-xl font-bold mt-2"> subscribers</span>
    </div>
    <table class="border border-2 w-[90%] mt-[3%]">
        <thead class="bg-white border border-2 bg-[#DFF1F0] dark:bg-gray-600">
            <tr>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Id</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Email</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">subscribed_at</th>
                <th scope="col" class="border border-2 px-6 py-3 text-left text-xs font-bold text-slate-950 uppercase tracking-wider dark:text-white">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-[#F2F8F7] border border-2 bg-white dark:bg-gray-600">
            <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars($subscriber['subscriber_id']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars($subscriber['email']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars(date( "F j, Y", strtotime($subscriber['subscribed_at']) ));?></td>

                    <td class="px-6 py-4 flex flex-row gap-4">
                        
                        <a href="<?=ROOT?>/admin/delete_subscriber?subscriber_id=<?php echo $subscriber['subscriber_id']; ?>" class="text-red-500 hover:text-red-700">
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
