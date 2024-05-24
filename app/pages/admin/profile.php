<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-8">
    <?php if ($message): ?>
        <p class="text-green-500"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if ($profile_picture):
        $public_path = str_replace('../public', ROOT, $profile_picture);
        ?>
        <div class="mt-8 flex flex-col ">
            <img src="<?= htmlspecialchars($public_path) ?>" alt="Profile Picture" class="w-32 h-32 rounded-lg">
            <form action="profile" method="post">
                <button type="submit" name="delete_picture" class="mt-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return   confirm('Do you really want to delete your picture?' )">Delete Picture</button>
            </form>
        </div>
    <?php else: ?>
        <p class="mt-8">No profile picture uploaded.</p>
    <?php endif; ?>

    <form action="profile" method="post" enctype="multipart/form-data" class="mt-8">
        <label for="profile_picture" class="block">Upload Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture" required class="mt-2">
        <button type="submit" class="mt-2 bg-[#00AAA1] text-white font-bold py-2 px-4 rounded">Upload</button>
    </form>

    <a href="dashboard.php" class="block mt-8 text-blue-500 hover:text-blue-600">Back to Dashboard</a>
</div>

</body>
</html>
