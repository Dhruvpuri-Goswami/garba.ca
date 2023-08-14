<?php
session_start();

include './php/connection.php';
include 'config.php'; 

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['username'] = ADMIN_USERNAME;
        header("Location: ./php/admin_dashboard.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            if ($user['is_verified'] == 0) {
                $error_message = "Please verify your email before logging in.";
                echo "<script>alert('{$error_message}');</script>";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                $_SESSION['logged_in'] = true;
                header("Location: ./user/user_dashboard.php");
                exit;
            }
        } else {
            $error_message = "Incorrect password.";
            echo "<script>alert('{$error_message}');</script>";
        }
    } else {
        $error_message = "User with the provided email not found. Redirecting to signup...";
        echo "<script>
                alert('{$error_message}');
                window.location.href = 'signup.php';
              </script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Pacifico&family=Quicksand&display=swap"
    rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="./style.css">
  <title>Garba.ca</title>
</head>

<body class="box-border">
  <header class="relative">
    <!-- Background Video -->
    <video class="  video absolute top-0 left-0 w-full h-[100vh] object-cover" autoplay muted loop playsinline>
      <source src="./content/vi edi.mp4" type="video/mp4">
      <!-- Add alternative video sources here (e.g., WebM, Ogg) -->
    </video>

    <!-- Internal Search and Other Section! -->
    <div class="absolute w-full h-[100vh] bg-opacity-80 bg-black  text-white">
      <nav class="flex justify-between mx-8 py-5 items-center">
        <div>
          <a href="/">
            <h2 class="text-3xl font-[Quicksand] font-bold">Garba</h2>
          </a>
        </div>
        <div class="flex gap-4">
          <a class="transition-all duration-100 py-1 px-2 md:px-5 border border-gray-400 cursor-pointer hover:border-white box-border text-sm md:text-lg"
            href="signup.php">Sign up</a>
        </div>

      </nav>

      <div class="h-[60vh] flex flex-col justify-center items-center">
        <div class="md:w-[50vw] relative text-center mb-1 md:mx-auto ">
          <h1 class=" text-[20vw] md:text-[12vw] font-[Abril] ">Garba</h1>
          <p
            class="relative bottom-6 text-[8vw] md:absolute md:bottom-5 md:right-[12vw] md:text-[2vw] text-yellow-500 font-[Pacifico]">
            Tradition Alive!</p>
        </div>
        <div class="mx-auto text-white  ">


          <form class="flex flex-col  rounded shadow-lg " method="post" action="">
            <label class="font-semibold text-xs" for="usernameField">Email ID</label>
            <input
              class="text-black flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2 focus:border-yellow-500"
              type="text" name="email" required>
            <label class="font-semibold text-xs mt-3" for="passwordField">Password</label>
            <input
              class="text-black lex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2  focus:border-yellow-500"
              type="password" name="password" required>
            <button
              class="flex items-center justify-center h-12 px-6 w-64 bg-yellow-600 mt-8 rounded font-semibold text-sm text-blue-100 hover:bg-yellow-700">Login</button>
            <div class="flex mt-6 justify-center text-xs">
              <a class="text-yellow-400 hover:text-yellow-500" href="#">Forgot Password</a>
              <span class="mx-2 text-gray-300">/</span>
              <a class="text-yellow-400 hover:text-yellow-500" href="signup.php">Sign Up</a>
            </div>
          </form>


        </div>
      </div>
    </div>
  </header>

  </div>

</body>


</html>