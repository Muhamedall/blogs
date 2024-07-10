<?php
require_once "../app/core/connection.php";

$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About <?= APP_NAME ?></title>
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
    <?php include "header.php"; ?>

    <section class="mt-[3%]">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-[#00AAA1] mb-6 animated-paragraph">About Us</h1>
            <div class="w-[80%] lg:w-[50%] text-center">
                <p class="text-xl animated-paragraph">
                    Welcome to <?= APP_NAME ?>! We are dedicated to sharing the latest updates and insights on triathlon. Our team consists of passionate individuals who live and breathe this sport. Through our blog, we aim to provide valuable information, training tips, and motivational stories to help you on your triathlon journey.
                </p>
                <p class="text-xl mt-4 animated-paragraph">
                    Whether you are a beginner or an experienced athlete, we have something for everyone. Join our community and stay updated with the latest trends, gear reviews, and race reports. Together, let's embrace the triathlon lifestyle and achieve our goals!
                </p>
            </div>
        </div>
        
        <div class="mt-[5%] flex flex-col items-center">
            <img src="../app/pages/team.jpg" alt="Our Team" class="w-[80%] lg:w-[50%] rounded-lg drop-shadow-lg animated-image">
            <h2 class="text-2xl font-bold mt-4 animated-paragraph">Meet Our Team</h2>
            <div class="w-[80%] lg:w-[50%] text-center mt-2">
                <p class="text-xl animated-paragraph">
                    Our team is composed of experienced triathletes, coaches, and enthusiasts who bring their expertise and passion to the table. We are here to support you every step of the way.
                </p>
            </div>
        </div>

        <div class="mt-[5%] flex flex-col items-center">
            <h2 class="text-2xl font-bold animated-paragraph">Our Mission</h2>
            <div class="w-[80%] lg:w-[50%] text-center mt-2">
                <p class="text-xl animated-paragraph">
                    Our mission is to inspire and empower individuals through the sport of triathlon. We believe in the power of community and the positive impact that triathlon can have on one's life. We are committed to providing high-quality content and resources to help you succeed.
                </p>
            </div>
        </div>

        <div class="mt-[5%] flex flex-col items-center">
            <h2 class="text-2xl font-bold animated-paragraph">Join Us</h2>
            <div class="w-[80%] lg:w-[50%] text-center mt-2">
                <p class="text-xl animated-paragraph">
                    Become a part of our growing community. Subscribe to our newsletter, follow us on social media, and never miss an update. Let's embark on this exciting journey together!
                </p>
            </div>
        </div>

        <?php if ($is_admin) { ?>
            <div class="mt-2 w-[80%] lg:w-[50%] mx-auto">
                <h3 class="text-2xl font-bold text-center mb-4">Edit About Us Content</h3>
                <form action="edit_about.php" method="post" class="bg-white p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <label for="about_content" class="block text-gray-700 text-sm font-bold mb-2">About Content:</label>
                        <textarea id="about_content" name="about_content" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="team_content" class="block text-gray-700 text-sm font-bold mb-2">Team Content:</label>
                        <textarea id="team_content" name="team_content" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="mission_content" class="block text-gray-700 text-sm font-bold mb-2">Mission Content:</label>
                        <textarea id="mission_content" name="mission_content" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="join_content" class="block text-gray-700 text-sm font-bold mb-2">Join Us Content:</label>
                        <textarea id="join_content" name="join_content" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Changes</button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </section>

    <footer>
        <?php include "footer.php"; ?>
    </footer>
</body>
</html>
