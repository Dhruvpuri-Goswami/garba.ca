<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
  <link rel="stylesheet"
    href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Pacifico&family=Quicksand&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body class="h-[100vh] w-[100vw] bg-gray-100 ">
  <div class="main-container md:max-w-[80vw]  mx-auto shadow-lg px-6 bg-white max-w-full ">
    <nav class="w-full bg-white h-20 flex justify-between items-center text-2xl pt-4 ">
      <div>
        <h2 class="font-[Pacifico] rotate-8 text-[30px] text-yellow-600 hover:text-yellow-500 cursor-pointer">Garba</h2>
      </div>
      <div>
        <input type="text" class="w-[40vw] rounded-full pl-6" placeholder="Search | Event | Location">
      </div>
      <div class="text-[20px] flex gap-6 pr-3 ">
        <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-house"></i></a>
        <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-user"></i></a>

      </div>
    </nav>


    <?php
    // Include your database connection file here
    include './php/connection.php';

    // Check if the event ID is passed as a parameter in the URL
    if (isset($_GET['event_id'])) {
      $event_id = $_GET['event_id'];

      // Fetch the event details from the database using the event_id
      $stmt = $conn->prepare("SELECT * FROM tbl_event WHERE event_id = ?");
      $stmt->bind_param("i", $event_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // Fetch the event details as an associative array
        $event = $result->fetch_assoc();

        // Close the statement
        $stmt->close();
      } else {
        // Redirect to the events page if the event ID is not found
        header("Location: events.php");
        exit();
      }
    } else {
      // Redirect to the events page if the event ID is not provided
      header("Location: events.php");
      exit();
    }
    ?>

    <div class="card pt-8 shadow-md p-12">
      <div class="w-full h-[80vh] flex flex-col md:flex-row md:h-full md:gap-8">
        <div class="w-1/2">
          <img class="w-full h-full object-cover rounded-md" style="max-width: 450px;"
            src="<?php echo $event['event_poster']; ?>" alt="">
        </div>
        <div class="md:w-1/2 md:pl-8">
          <div class="py-4 font-[Quicksand]">
            <h3 class="text-4xl font-semibold mb-1">
              <?php echo $event['event_name']; ?>
            </h3>
            <p class="text-lg text-gray-500 mt-2 mb-1"><i class="fa-solid fa-location-dot"></i>
              <?php echo $event['event_venue']; ?>
            </p>
            <p class="text-lg text-gray-500 mb-1"><i class="fa-solid fa-calendar-days"></i>
              <?php echo date('d/m/y', strtotime($event['event_start_date'])); ?> -
              <?php echo date('d/m/y', strtotime($event['event_end_date'])); ?>
            </p>
            <p class="text-lg text-gray-500 mb-1"><i class="fa-solid fa-clock"></i>
              <?php echo date('g:i A', strtotime($event['event_start_time'])); ?> to
              <?php echo date('g:i A', strtotime($event['event_end_time'])); ?>
            </p>
            <p class="mt-4">
              <?php echo $event['event_desc']; ?>
            </p>
          </div>
          <div class="mt-4">
            <h3 class="mb-2">Contact :</h3>
            <p class="text-gray-600"><i class="fa-solid fa-phone"></i> Phone:
              <?php echo $event['event_contact']; ?>
            </p>
            <p class="text-gray-600"><i class="fa-solid fa-envelope"></i> Email:
              <?php echo $event['gmail']; ?>
            </p>
          </div>
        </div>
      </div>
    </div>



    <div class=" md:pt-8 md:mt-12">
      <footer class="relative bg-blueGray-200 pb-6 ">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap text-left lg:text-left">
            <div class="w-full lg:w-6/12 px-4">
              <h4 class="text-3xl fonat-semibold text-blueGray-700">Let's make our comminity strong!</h4>
              <h5 class="text-lg mt-0 mb-2 text-blueGray-600">
                spread our culture across the world!
              </h5>
              <div class="mt-6 lg:mb-0 mb-6">
                <button
                  class="bg-white text-lightBlue-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2"
                  type="button">
                  <i class="fa fa-twitter"></i></button><button
                  class="bg-white text-lightBlue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2"
                  type="button">
                  <i class="fa fa-facebook"></i></button><button
                  class="bg-white text-pink-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2"
                  type="button">
                  <i class="fa fa-instagram"></i></button>
              </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
              <div class="flex flex-wrap items-top mb-6">
                <div class="w-full lg:w-4/12 px-4 ml-auto">
                  <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Useful Links</span>
                  <ul class="list-unstyled">
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://www.creative-tim.com/presentation?ref=njs-profile">About Us</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://blog.creative-tim.com?ref=njs-profile">Blog</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://www.github.com/creativetimofficial?ref=njs-profile">Events</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://www.creative-tim.com/bootstrap-themes/free?ref=njs-profile">Giveaways</a>
                    </li>
                  </ul>
                </div>
                <div class="w-full lg:w-4/12 px-4">
                  <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Other Resources</span>
                  <ul class="list-unstyled">
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://github.com/creativetimofficial/notus-js/blob/main/LICENSE.md?ref=njs-profile">MIT
                        License</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://creative-tim.com/terms?ref=njs-profile">Terms &amp; Conditions</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://creative-tim.com/privacy?ref=njs-profile">Privacy Policy</a>
                    </li>
                    <li>
                      <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                        href="https://creative-tim.com/contact-us?ref=njs-profile">Contact Us</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <hr class="my-6 border-blueGray-300">
          <div class="flex flex-wrap items-center md:justify-between justify-center">
            <div class="w-full md:w-4/12 px-4 mx-auto text-center">
              <div class="text-sm text-blueGray-500 font-semibold py-1">
                Copyright © <span id="get-current-year">2021</span><a
                  href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800"
                  target="_blank"> Garba.ca
                  <a href="https://www.creative-tim.com?ref=njs-profile"
                    class="text-blueGray-500 hover:text-blueGray-800">Team</a>.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>

</body>

</html>