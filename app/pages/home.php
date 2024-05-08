
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home <?= APP_NAME ?></title>
	<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animated-paragraph {
    animation: fadeIn 1s ease-in-out;
	
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .animated-image {
    animation: fadeIn 1s ease-in-out;
  }
 
  
</style>
	
	
<script src="https://cdn.tailwindcss.com"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</head>

<body class="bg-[#F2F8F7]">
	<?php include "header.php" ?>
	<section class="mt-[3%]">
		<div class="flex flex-row gap-[40%] ">
			<div class="description w-[20%] ml-[10%]  ">
				<h2 class="text-2xl font-bold animated-paragraph ">
				A dedicated blogger and passionate about triathlon, oversees various activities related to the sport. 
				</h2>

			</div>
			<div>
                <img class="w-[60%] rounded-lg drop-shadow-lg animated-image" src="Kiluua.jpg" alt="kilua">
            </div>

	
		
		</div>
		<main>
		<div class="flex flex-row  lg:ml-[3%]">
			<h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Featured  </h1><span class="text-xl font-bold mt-2"> This month<span>
				

			</div>
			<?php include "blogsPost.php"; ?>

		</main>
		
	</section>
	
	<footer class="mt-[100%]">


	   <?php  include "footer.php";  ?>
	</footer>
</body>



</html>