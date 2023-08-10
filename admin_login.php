<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == "admin" && $password == "admin") {
        $_SESSION["username"] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo '<script>alert("Incorrect username or password!")</script>';
    }
}
?>


<!-- Your HTML form goes here -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <!-- Video background -->
    <video class="fixed top-0 left-0 w-full h-full object-cover z-0 opacity-70" autoplay muted loop>
        <source src="./content/vi edi.mp4" type="video/mp4">
        <!-- Add more video sources here for cross-browser support -->
    </video>

    <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full relative z-10">
        <!-- Back arrow inside the login section -->
        <div class="absolute top-2 left-4 text-black text-3xl cursor-pointer" onclick="window.history.back()">
            &larr;
        </div>
        <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Welcome Back!</h2>
        <form method="post" action="">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Login</button>
                <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>

</html>