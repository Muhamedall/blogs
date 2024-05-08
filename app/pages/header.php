<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<nav class="relative    px-4 py-4 flex justify-between items-center bg-[#E8F3F3]">
		
	
		<ul class="hidden lg:ml-[5%] absolute lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
			<li><a class="text-sm   font-bold" href= "<?=ROOT?>" class="nav-link px-2 <?=$url[0] =='home' ? 'link-primary':'link-dark'?>">Home</a></li>
			
			<li class="text-gray-300">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  />
				</svg>
			</li>
			<li><a  class="text-sm   font-bold" href="<?=ROOT?>/about" class="nav-link px-2  <?=$url[0] =='about' ? 'link-primary':'link-dark'?>">About</a></li>
			<li class="text-gray-300">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  />
				</svg>
			</li>
			<li><a class="text-sm font-bold" href="#">Categories</a></li>
		
			
		</ul>
		<div class="flex flex-row lg:ml-[50%]">
			<h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Blog</h1><span class="text-xl font-bold mt-2">Diaa<span>

			</div>
			<ul class="lg:ml-[30%]  lg:flex lg:mx-auto lg:flex lg:items-center  lg:space-x-6">

			<svg xmlns="http://www.w3.org/2000/svg" x="0px" class="w-[13%]" viewBox="0 0 50 50">
<path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"></path>
</svg>

<li><a class="text-sm font-bold" href="#">Contact</a></li>	</ul></nav>
</body>
</html>