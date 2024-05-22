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
