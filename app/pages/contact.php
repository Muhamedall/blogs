<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us <?= APP_NAME ?></title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated-section {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2F8F7]">
    <?php include "header.php" ?>
    <section class="mt-12 lg:mt-8 container mx-auto px-4">
        <div class="animated-section">
            <h1 class="text-3xl font-bold text-center mb-8">Contact Us</h1>
            <div class="flex flex-col lg:flex-row lg:gap-16 items-start">
                <!-- Contact Form -->
                <div class="w-full lg:w-1/2">
                    <form action="process_contact.php" method="POST" class="bg-white p-8 shadow-lg rounded-lg">
                        <div class="mb-4">
                            <label for="name" class="block text-lg font-semibold mb-2">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00AAA1]" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-lg font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00AAA1]" required>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-lg font-semibold mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00AAA1]" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-lg font-semibold mb-2">Message</label>
                            <textarea id="message" name="message" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00AAA1]" rows="5" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="bg-[#00AAA1] text-white font-bold py-2 px-4 rounded hover:bg-[#007d76] transition duration-300">Send Message</button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="w-full lg:w-1/2 mt-8 lg:mt-0">
                    <div class="bg-white p-8 shadow-lg rounded-lg">
                        <h2 class="text-2xl font-bold mb-4">Our Contact Information</h2>
                        <p class="mb-4">If you have any questions, feel free to reach out to us via the contact form or through the following contact details:</p>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold">Address:</h3>
                            <p>123 Triathlon Street,<br>Sport City, SC 12345</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold">Phone:</h3>
                            <p>+1 (123) 456-7890</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold">Email:</h3>
                            <p>info@triathlonwebsite.com</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Social Media:</h3>
                            <p>Follow us on social media for the latest updates.</p>
                            <div class="flex space-x-4 mt-2">
                                <a href="#" class="text-[#00AAA1] hover:text-[#007d76]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
                                        <path d="M5.026 15V9H3V6h2.026V4.5c0-2.089 1.284-3.5 3.332-3.5.979 0 1.823.074 2.067.107V4H8.372c-1.231 0-1.47.587-1.47 1.438V6h2.793l-.364 3H6.902v6H5.026z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-[#00AAA1] hover:text-[#007d76]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
                                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.64 2.564 6.657 5.955 7.746.435.08.595-.183.595-.41 0-.202-.007-.737-.01-1.446-2.425.526-2.94-1.172-2.94-1.172-.396-1.006-.967-1.274-.967-1.274-.792-.542.06-.531.06-.531.875.062 1.334.899 1.334.899.779 1.334 2.045.949 2.543.726.08-.565.306-.95.556-1.168-1.937-.22-3.972-.968-3.972-4.318 0-.954.34-1.733.898-2.344-.09-.222-.39-1.114.086-2.324 0 0 .732-.235 2.4.896.696-.194 1.442-.292 2.183-.296.741.004 1.487.102 2.183.296 1.667-1.13 2.398-.896 2.398-.896.476 1.21.176 2.102.087 2.324.56.611.897 1.39.897 2.344 0 3.358-2.038 4.096-3.982 4.308.315.27.597.812.597 1.637 0 1.183-.01 2.138-.01 2.428 0 .23.158.496.598.41C13.438 14.656 16 11.64 16 8c0-4.42-3.58-8-8-8z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-[#00AAA1] hover:text-[#007d76]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
                                        <path d="M8.05 3.065a5 5 0 1 1-1.935 9.87A5 5 0 0 1 8.05 3.065zM8 0a8 8 0 1 0 6.32 12.906A8 8 0 0 0 8 0zM6.842 7.137a1.1 1.1 0 1 1 2.137.271 1.1 1.1 0 0 1-2.137-.27zm4.611 1.506c-.085-.169-.52-.279-1.122-.28-.498-.005-1.073.171-1.43.363.235.234.451.48.649.736.058.075.116.155.164.237.037.061.055.094.103.151.088.104.174.206.262.303.221-.288.617-.549 1.003-.551.302-.002.565.125.73.328.193-.312.298-.691.308-1.093-.002-.117-.053-.186-.101-.249zm-2.684 1.405c-.4-.404-.736-.911-.998-1.49-.117-.257-.229-.522-.338-.79-.103-.247-.205-.502-.305-.757a7.9 7.9 0 0 1-.056-.118c-.118-.223-.248-.431-.387-.633a7.494 7.494 0 0 0-1.243 4.506c.012.24.025.48.039.722.072.5.215 1.006.42 1.508-.007-.048-.013-.097-.021-.145-.05-.27-.08-.544-.083-.821a5.47 5.47 0 0 1 2.071-4.712c-.056.074-.107.147-.16.222a9.99 9.99 0 0 1-.247.328c.31.118.62.242.926.368a10.09 10.09 0 0 1 .435-.512c-.245-.102-.492-.196-.741-.283a10.025 10.025 0 0 0 1.238.362c.056-.09.115-.178.174-.267z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</body>
</html>
