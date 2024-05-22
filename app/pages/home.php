
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
                <img src="../public/personne.jpg" alt="kilua" class="w-[60%] rounded-lg drop-shadow-lg animated-image" >
            </div>
   
	
			
		
		</div>
             <div class="mt-[5%]">
			 <div class="flex flex-row  lg:ml-[3%]">
			<h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Featured  </h1><span class="text-xl font-bold mt-2"> This month<span>
				

			</div>
                <?php include "blogsPost.php"; ?>
            
   

</div>
<div class=" ml-[40%] flex flex-row gap-5 mt-4">
    <a href="?slide=<?php echo $prevSlide; ?>" class="bg-[#00AAA1]  text-white font-bold py-2 px-4 rounded <?php echo $prevDisabled; ?> flex items-center">
        <span class="mr-2">Previous</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <a href="?slide=<?php echo $nextSlide; ?>" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded <?php echo $nextDisabled; ?> flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="ml-2">Next</span>
    </a>
</div>

<div class="flex flex-row  lg:ml-[3%]">
			<h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Youtube  </h1><span class="text-xl font-bold mt-2"> Posts<span>
				

			</div>
      <div id="app">
       
    </div>
<div class="grid grid-cols-6 gap-[2%]  w-[100%]" id="videos"></div>

    </section>

    <footer>
        <?php include "footer.php"; ?>
    </footer>

   
</body>

<script>
  const apiKey = 'AIzaSyAPPrKa9BXeR3A5frXFgSFg2ZQapGqJ2a8';
const channelId = 'UC4muHgvt5FNOUm-lxvMB6TQ';

const apiUrl = `https://www.googleapis.com/youtube/v3/search?key=${apiKey}&channelId=${channelId}&part=snippet&order=date&maxResults=10`;

fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        const videosContainer = document.getElementById('videos');

        data.items.forEach(item => {
            const videoId = item.id.videoId;
            const title = item.snippet.title;

            const videoElement = `
                <div class="w-full h-64 text-center mt-5">
                    <iframe class="rounded-lg w-full h-full" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h2 class="text-sm mt-2">${title}</h2>
                </div>
                <hr>
            `;

            videosContainer.innerHTML += videoElement;
        });
    })
    .catch(error => console.error('Error fetching YouTube videos:', error));

</script>

</html>