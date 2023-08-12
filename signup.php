<?php

include './php/connection.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
    $error_message = 'Please fill in all fields.';
  } else {
    if ($password !== $confirm_password) {
      $error_message = 'Passwords do not match.';
    } else {

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $conn->prepare("INSERT INTO tbl_user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

      if ($stmt->execute()) {
        echo "<script>alert('Registration successful');</script>";
        header("Location: login.php");
      } else {
        $error_message = 'There was an error registering the user.';
      }

      $stmt->close();
    }
  }

  if (!empty($error_message)) {
    echo "<script>alert('{$error_message}');</script>";
  }
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
          <h2 class="text-3xl font-[Quicksand] font-bold">Garba</h2>
        </div>
        <div class="flex gap-4">
          <a href="login.php"
            class="transition-all duration-100 py-1 px-2 md:px-5 border border-gray-400 cursor-pointer hover:border-white box-border text-sm md:text-lg">Sign
            In</a>
        </div>

      </nav>

      <div class="h-[60vh] mt-3 flex flex-col justify-center items-center">
        <div class="md:w-[50vw] relative text-center mb-1 md:mx-auto ">
          <h1 class=" text-[20vw] md:text-[12vw] font-[Abril] ">Garba</h1>
          <p
            class="relative bottom-6 text-[8vw] md:absolute md:bottom-5 md:right-[12vw] md:text-[2vw] text-yellow-500 font-[Pacifico]">
            Tradition Alive!</p>
        </div>
        <div class="mx-auto ">


          <form class="flex flex-col  rounded shadow-lg" method="post" action="">
            <div>
              <div class="flex -mx-3 flex-col md:flex-row">
                <div class="md:w-1/2 px-3 mb-5">
                  <label for="" class="text-xs font-semibold px-1">First name</label>
                  <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i
                        class="mdi mdi-account-outline text-gray-400 text-lg"></i></div>
                    <input type="text" name="first_name"
                      class="text-black w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"
                      placeholder="John" required>
                  </div>
                </div>
                <div class="md:w-1/2 px-3 mb-5">
                  <label for="" class="text-xs font-semibold px-1">Last name</label>
                  <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i
                        class="mdi mdi-account-outline text-gray-400 text-lg"></i></div>
                    <input type="text" name="last_name"
                      class="text-black w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"
                      placeholder="Smith" required>
                  </div>
                </div>
              </div>
              <div class="flex -mx-3">
                <div class="w-full px-3 mb-5">
                  <label for="" class="text-xs font-semibold px-1">Email</label>
                  <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i
                        class="mdi mdi-email-outline text-gray-400 text-lg"></i></div>
                    <input type="email" name="email"
                      class="text-black w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"
                      placeholder="johnsmith@example.com" required>
                  </div>
                </div>
              </div>
              <div class="flex -mx-3">
                <div class="w-full px-3 mb-12">
                  <label for="" class="text-xs font-semibold px-1">Password</label>
                  <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i
                        class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                    <input type="password" name="password"
                      class="text-black w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"
                      placeholder="************" required>
                  </div>
                </div>
                <div class="w-full px-3 mb-12">
                  <label for="" class="text-xs font-semibold px-1">Confirm Password</label>
                  <div class="flex">
                    <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><i
                        class="mdi mdi-lock-outline text-gray-400 text-lg"></i></div>
                    <input type="password" name="confirm_password"
                      class="text-black w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-indigo-500"
                      placeholder="************" required>
                  </div>
                </div>
              </div>
              <div class="flex -mx-3">
                <div class="w-full px-3 mb-5">
                  <button
                    class="block w-full max-w-xs mx-auto bg-yellow-500 hover:bg-yellow-700 focus:bg-yellow-700 text-white rounded-lg px-3 py-3 font-semibold"
                    name="register" type="submit">REGISTER NOW</button>
                </div>
              </div>

            </div>
          </form>
          <!-- Component End  -->


        </div>
      </div>
    </div>
  </header>

  </div>

</body>


</html>
<style>
  @import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css')
</style>