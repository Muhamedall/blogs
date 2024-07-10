

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

        .animated-image {
            animation: fadeIn 1s ease-in-out;
        }
         
  .fade-in {
    animation: fadeIn 1s ease-out;
  }

  @keyframes slideIn {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
  }

  .slide-in {
    animation: slideIn 1s ease-out;
  }
        
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2F8F7]">
    <?php include "header.php" ?>
    <section class="mt-[3%]">
        <div class="static flex flex-row lg:gap-[40%]  ">
            <div class=" description   lg:w-[50%] ml-[10%]">
                <h2 class=" absolute ml-[10%] mt-[90%] lg:mt-[5%] lg:relative  text-2xl font-bold animated-paragraph ">
                    A dedicated blogger and passionate about triathlon, oversees various activities related to the sport.
                </h2>
            </div>
            <div>
                <img src="../app/pages/mrdiaa.jpg" alt="mr-diaa" class="  lg:w-[80%] rounded-lg drop-shadow-lg animated-image">
            </div>
        </div>
        <div class="mt-[70%] lg:mt-[5%]">
            <div class=" ml-[5%] flex flex-row lg:ml-[3%] ">
                <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Featured</h1>
                <span class="text-xl font-bold mt-2 slide-in">This month<span>
            </div>
            <?php include "blogsPost.php"; ?>
        </div>
        <div class="ml-[10%] lg:ml-[40%] flex flex-row gap-5 mt-4">
            <a href="?slide=<?php echo $prevSlide; ?>" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded <?php echo $prevDisabled; ?> flex items-center">
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
        <div class="mt-[5%]">
            <div class="ml-[5%] flex flex-row lg:ml-[3%] ">
                <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">YouTube</h1>
                <span class="text-xl font-bold mt-2 slide-in">Posts<span>
            </div>
            <div id="app "></div>
            <div class="lg:grid lg:grid-cols-6 lg:gap-[2%] w-[100%] ml-[5%]" id="videos"></div>
            <div class="flex justify-center mt-4">
                <a href="https://www.youtube.com/channel/UC4muHgvt5FNOUm-lxvMB6TQ" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded" target="_blank">
                    More Videos
                </a>
            </div>
        </div>
        <div class="ml-[5%] flex flex-row lg:ml-[3%] mt-8 fade-in">
  <h1 class="bg-[#00AAA1] text-[#FFFFFF] font-bold text-2xl">Today’s</h1>
  <span class="text-xl font-bold mt-2 slide-in">update</span>
</div>

<div id="todays-update" class="  ml-[5%] mt-4 lg:p-4 bg-white shadow rounded-lg lg:flex lg:flex-row lg:gap-[20%]">
  <div class="static bg-[#F2F8F7] p-2 lg:ml-[15%] rounded-xl fade-in">
    <h1 class="text-[#00AAA1] font-bold">New post           
      
      <span id="update-posts"></span>
    </h1>
  </div>
  <div class=" static bg-[#F2F8F7] p-2 rounded-xl fade-in">
    <h1 class="text-[#00AAA1] font-bold">Visitors Today
      <span id="update-visitors"></span>
    </h1>
    
  </div>
  <div class="static bg-[#F2F8F7] p-2 rounded-xl fade-in">
    <h1 class="text-[#00AAA1] font-bold">Subscribers Today
      <span id="update-subscribers"></span>
    </h1>
    
  </div>
</div>
    </section>
    <footer>
        <?php include "footer.php"; ?>
    </footer>
    <script>
        const apiKey = 'AIzaSyAPPrKa9BXeR3A5frXFgSFg2ZQapGqJ2a8';
        const channelId = 'UC4muHgvt5FNOUm-lxvMB6TQ';
        const apiUrl = `https://www.googleapis.com/youtube/v3/search?key=${apiKey}&channelId=${channelId}&part=snippet&order=date&maxResults=6`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const videosContainer = document.getElementById('videos');
                data.items.forEach(item => {
                    const videoId = item.id.videoId;
                    const title = item.snippet.title;
                    const videoElement = `
                        <div class="w-full text-center mt-5">
                            <iframe class="rounded-lg" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h2 class="text-sm mt-2">${title}</h2>
                        </div>
                        <hr>
                    `;
                    videosContainer.innerHTML += videoElement;
                });
            })
            .catch(error => console.error('Error fetching YouTube videos:', error));

        document.addEventListener('DOMContentLoaded', function() {
            fetch('<?=ROOT?>/todayUpdate')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('update-posts').innerText = '' + data.todayPostsCount;
                    document.getElementById('update-visitors').innerText = '' + data.todayVisitorsCount;
                    document.getElementById('update-subscribers').innerText = '' + data.newSubscribersCount;
                })
                .catch(error => console.error('Error fetching today\'s update:', error));
        });
      
        document.getElementById('search-button').addEventListener('click', function() {
            performSearch();
        });

        document.getElementById('search-input').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        function performSearch() {
            const searchTerm = document.getElementById('search-input').value.trim();

            if (searchTerm.length === 0) {
                clearSearchResults();
                return;
            }

            // Perform AJAX request to search PHP scripts
            searchPosts(searchTerm);
            searchVideos(searchTerm);
        }

        function searchPosts(searchTerm) {
            fetch(`search_posts.php?q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data, 'Posts');
                })
                .catch(error => console.error('Error searching posts:', error));
        }

        function searchVideos(searchTerm) {
            fetch(`search_videos.php?q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data.items, 'Videos'); // Assuming data structure matches YouTube API response
                })
                .catch(error => console.error('Error searching videos:', error));
        }

        function displaySearchResults(results, type) {
            const searchResultsContainer = document.getElementById('search-results');
            let html = `<h2 class="font-bold mt-2">${type}</h2>`;

            if (results.length > 0) {
                results.forEach(result => {
                    if (type === 'Videos') {
                        html += `<div class="mt-2"><h3 class="text-blue-600">${result.snippet.title}</h3><p>${result.snippet.description}</p></div>`;
                    } else {
                        html += `<div class="mt-2"><h3 class="text-blue-600">${result.title}</h3><p>${result.content}</p></div>`;
                    }
                });
            } else {
                html += '<p>No results found.</p>';
            }

            searchResultsContainer.innerHTML = html;
        }

        function clearSearchResults() {
            document.getElementById('search-results').innerHTML = '';
        }

    </script>
</body>
</html>
