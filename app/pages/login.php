<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    }

    if (empty($_POST["password"])) {
        $errors['password'] = "Password is required";
    }

    if (empty($errors)) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "myblogs_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        //  admins table
        $sql = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Admin authentication successful
            session_start();
            if ( $_SESSION['admin'] = true) {
           
            header("Location: " . ROOT . "/admin");

            exit();
        } else {
            // Invalid credentials
            $errors['email'] = "Invalid email or password";
        }

        $conn->close();
    }
}}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
  
</head>
<body>
    <header>
        <?php include "header.php" ?>
    </header>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f4f3]">
            <div>
                <a href="home">
                    <h2 class="font-bold text-3xl">Diaa <span class="bg-[#00AAA1]  text-white px-2 rounded-md">blog</span></h2>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form method="POST" >
                    <div class="py-8">
                        <center>
                            <span class="text-2xl font-semibold">Log In</span>
                        </center>
                    </div>

                    <?php if (!empty($errors['email'])): ?>
                        <p class="text-red-600"><?= $errors['email'] ?></p>
                    <?php endif; ?>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" >Email</label>
                        <input type="text" name="email" placeholder="Email" class="w-full rounded-md py-2.5 px-4 border text-sm border-[#94D7D3] outline-[#00AAA1]" >
                    </div>

                    <?php if (!empty($errors['password'])): ?>
                        <p class="text-red-600"><?= $errors['password'] ?></p>
                    <?php endif; ?>

                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700">Password</label>
                        <input type="password" name="password" placeholder="Password" class="w-full rounded-md py-2.5 px-4 border border-[#94D7D3] text-sm outline-[#00AAA1]" autocomplete="current-password" >
                    </div>
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember" class="rounded border-[#94D7D3] outline-[#00AAA1]  shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600 ">Remember Me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="hover:underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Forgot your password?</a>
                        <button  type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-[#94D7D3] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#00AAA1]   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Log In</button>
                    </div>
                </form>
                <div class="text-center mt-[5%] text-sm">
                    © <?php echo date('Y') ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
