<?php include '../app/pages/admin/manager-posts.php';?>
<style>
    #postForm {
    display: none;
}

</style>
<body>
<script src="https://cdn.tailwindcss.com"></script>
<div >
<div class="flex flex-row mt-[10%]">
    <h1 class="bg-[#00AAA1] ml-[5%] text-[#FFFFFF] font-bold text-2xl">Create</h1>
    <span class="text-xl font-bold mt-2"> Posts<span>
</div>
<form id="postForm"   class="w-[40%] ml-[5%] mt-[20px] container grid grid-cols-2 gap-4" method="POST" enctype="multipart/form-data">
    <div class="mb-5">
        <label for="title" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Title</label>
        <input type="text" name="title" id="title" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
    </div>
    <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Category</label>
        <select id="category" name="category" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="travel">Triathlon</option>
            <option value="opinions">Opinions</option>
            <option value="stories">Stories</option>
            <option value="productivity">Productivity</option>
            <option value="experiences">Experiences</option>
        </select>
    </div>
    <div class="mb-5 col-span-2">
        <label for="image_or_video" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Upload Image or Video</label>
        <input type="file" name="image_or_video" id="image_or_video" class="block w-full p-4 text-gray-900 border border-[#00AAA1] rounded-lg bg-gray-50 text-base focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
    <div class="mb-5 col-span-2">
        <label for="content" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Content</label>
        <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-[#00AAA1] focus:ring-[#00AAA1] focus:border-[#00AAA1] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description..."></textarea>
    </div>
    <button type="submit" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded">Add Post</button>
</form>
</div> 
<script>
    document.getElementById('addNewPostBtn').addEventListener('click', function() {
        document.getElementById('postForm').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('postForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Perform form submission via AJAX or regular submission
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        }).then(response => {
            if (response.ok) {
                this.reset();
                document.getElementById('postForm').style.display = 'none';
                document.getElementById('addNewPostBtn').style.display = 'block';
            } else {
                alert('Error submitting the form');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>