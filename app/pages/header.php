
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<nav class="relative px-4 lg:px-8 py-4 flex justify-between items-center bg-[#E8F3F3]">
    <div class="flex items-center">
        <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl px-2">Blog</h1>
        <span class="text-xl font-bold ml-2">Diaa</span>
    </div>
    <ul class="hidden lg:flex space-x-6">
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'home' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>">Home</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'about' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/about">About</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'categorie' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/categorie" >Categories</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'contact' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/contact">Contact</a></li>
    </ul>
    <div class="flex items-center">
        <button id="search-button" class="lg:ml-4">
            <svg class="h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.35 7.65a7.5 7.5 0 010 10.6z" />
            </svg>
        </button>
        <button class="lg:hidden flex items-center px-2 py-1 border rounded ml-4" id="mobile-menu-button">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>

<!-- Search Input -->
<div class="hidden px-4 lg:px-8 py-4 bg-[#E8F3F3]" id="search-container">
    <input type="text" class="w-full lg:w-[50%]  px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00AAA1]" placeholder="Search..." id="search-input">
</div>

<div class="lg:hidden" id="mobile-menu">
    <ul class="flex flex-col space-y-4 mt-2">
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'home' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>">Home</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'about' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/about">About</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'categorie' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/categorie" >Categories</a></li>
        <li><a class="text-sm font-bold px-2 <?= $url[0] == 'contact' ? 'text-primary' : 'text-dark' ?>" href="<?= ROOT ?>/contact">Contact</a></li>
    </ul>
</div>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // Toggle search input

    document.getElementById('search-button').addEventListener('click', function () {
        const searchContainer = document.getElementById('search-container');
        searchContainer.classList.toggle('hidden');
    });
</script>

</body>
</html>
