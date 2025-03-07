<?php
// Include your database connection file here
include './php/connection.php';
$sql = "UPDATE tbl_event SET is_complete = '1' WHERE event_end_date < CURDATE()";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Pacifico&family=Quicksand&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


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
    <video class="  video absolute top-0 left-0 w-full h-[85vh] object-cover" autoplay muted loop playsinline>
      <source src="./content/vi edi.mp4" type="video/mp4">
      <!-- Add alternative video sources here (e.g., WebM, Ogg) -->
    </video>

    <!-- Internal Search and Other Section! -->
    <div class="absolute w-full h-[85vh] bg-opacity-80 bg-black  text-white">
      <nav class="flex justify-between mx-8 py-5 items-center">
        <div>
          <a href="index.php"><h2 class="text-3xl font-[Quicksand] font-bold">Garba</h2></a>
          
        </div>
        <div class="flex gap-4">
          <a href="login.php"
            class="transition-all duration-100 py-1 px-5 border border-gray-400 cursor-pointer hover:border-white box-border">Login</a>
          <a href="signup.php"
            class="transition-all duration-100 py-1 px-5 border border-gray-400 cursor-pointer hover:border-white box-border">Sign
            up</a>
        </div>

      </nav>

      <div class="h-[50vh] flex flex-col justify-center items-center">
        <div class="md:w-[50vw] relative text-center mb-1 md:mx-auto ">
          <h1 class=" text-[20vw] md:text-[12vw] font-[Abril] ">Garba</h1>
          <p
            class="relative bottom-6 text-[8vw] md:absolute md:bottom-5 md:right-[12vw] md:text-[2vw] text-yellow-500 font-[Pacifico]">
            Tradition Alive!</p>
        </div>
        <div class=" w-[90vw] h-36 md:w-[60vw] md:h-14 flex flex-col md:flex-row ">
          <input
            id="inputFieldIndex"
            class=" text-center md:text-left md:pl-8 h-16 md:h-full font-[Quicksand] font-bold text-[1.2em] md:text-[1.5em] outline-none w-full md:rounded-tl-md md:rounded-bl-md bg-white text-black"
            placeholder="Search Event" type="text">
          <button
            onclick="sendValue()"
            class="py-2  w-32 mx-auto my-4 rounded-full md:my-0 md:rounded-none bg-yellow-500 md:rounded-tr-md md:rounded-br-md md:px-4 md:py-0 md:h-full">Search</button>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Sections -->

  <div class="absolute h-52 mt-[85vh] w-full">

    <!-- Heading Section -->

    <div class="w-full md:px-14">


      <div class="w-full text-center py-5 main-div ">
        <h3
          class="text-[2em] md:text-[2.4em] my-[1em] w-[50vw] md:w-[30vw] mx-auto hover:border-b-4 hover:text-yellow-500 border-yellow-500 transition-all duration-100  py-0 font-[Quicksand] font-bold">
          Featured Events
        </h3>
      </div>



      <div class="w-full h-full my-2">

        <!-- event -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
          <?php

          // Fetching all event details from the database
          $sql = "SELECT * FROM tbl_event WHERE is_featured='1' LIMIT 4";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              ?>

              <div class="relative mx-auto w-full">
                <a href="mainCard.php?event_id=<?php echo $row['event_id']; ?>"
                  class="relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full">
                  <div class="shadow-md shadow-gray-300 p-4 rounded-lg bg-white">
                    <div class="flex justify-center relative rounded-lg overflow-hidden h-72">
                      <div class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full">
                        <div class="absolute inset-0 bg-black">
                          <!-- Display the event poster image from database -->
                          <?php
                          $imageLink = str_replace("../", "./", $row['event_poster']);
                          ?>
                          <img class="object-cover w-full h-full" src="<?php echo $imageLink; ?>" alt="Event Poster">
                        </div>
                      </div>

                      <div class="absolute flex justify-center bottom-0 mb-3">
                        <div class="flex bg-white px-4 py-1 space-x-5 rounded-lg overflow-hidden shadow">
                          <p class="flex items-center font-medium text-gray-800">
                            <!-- You can add additional information here if needed -->
                          <div></div>
                          </p>
                        </div>
                      </div>

                      <span
                        class="absolute top-0 left-0 inline-flex mt-3 ml-3 px-3 py-2 rounded-lg z-10 bg-red-500 text-sm font-medium text-white select-none">
                        Featured
                      </span>
                    </div>

                    <div class="mt-4">
                      <!-- Display the event name from database -->
                      <h2 class="title font-medium text-base md:text-[20px] text-gray-800 line-clamp-1">
                        <?php echo $row['event_name']; ?>
                      </h2>
                      <!-- Display the event venue from database -->
                      <p class="loc mt-1 text-[12px] text-gray-800 line-clamp-1">
                        <?php echo $row['event_venue']; ?>
                      </p>
                    </div>

                    <div class="grid grid-cols-2 mt-2">
                      <!-- Display the event start and end date from database -->
                      <p class="inline-flex flex-col xl:flex-row xl:items-center">
                        <?php
                        $start_date = strtotime($row['event_start_date']);
                        $end_date = strtotime($row['event_end_date']);
                        echo date('d/m/y', $start_date) . ' ' . date('l', $start_date);
                        ?>
                      </p>
                      <!-- Display the event start and end time from database -->
                      <p class="inline-flex flex-col xl:flex-row xl:items-center">
                        <?php
                        $start_time = date('g:i A', strtotime($row['event_start_time']));
                        // $end_time = date('g:i A', strtotime($row['event_end_time']));
                        echo $start_time;
                        ?>
                      </p>
                    </div>

                  </div>
                </a>
              </div>

              <?php
            }
          }
          $conn->close();
          ?>



        </div>

        <!-- event -->
        <div class="text-center my-12">
          <a href="events.php"
            class="text-2xl px-6 py-2 rounded-lg hover:border-4 my-24 transition-all duration-100 bg-yellow-500 hover:text-white">
            more events
          </a>
        </div>
        <div class="bg-black h-fit flex flex-col md:flex-row mb-24">
          <div class="h-[50%]  text-white m-8 md:mt-16 md:w-[50%] md:h-full">
            <h3 class="text-yellow-500 font-[Quicksand] text-3xl font-extrabold md:text-[80px] ">COMMUNITY</h3>
            <p class="font-sans pl-1 mt-2 tracking-tighter md:mt-10 md:text-2xl">Amidst Canada's diverse tapestry, the
              Garba community weaves its vibrant threads, dancing to the rhythm of unity. In every swirling step, we
              celebrate our heritage, bridging cultures, and fostering joy. Together, we kindle the flame of tradition,
              illuminating the maple nation with the warmth of our shared celebrations, keeping our roots alive..</p>
          </div>
          <div class="h-[50%] md:w-[50%] md:h-full">
            <img class="h-full w-full object-cover" src="./content/Images/garba1.webp" alt="">
          </div>
        </div>



        <!-- request section -->






        <!-- footer section -->

        <div class="pt-56 md:pt-8 md:mt-12 bg-gray-300">
          <footer class="relative bg-blueGray-200 pt-8 pb-6">
            <div class="container mx-auto px-4">
              <div class="flex flex-wrap text-left lg:text-left">
                <div class="w-full lg:w-6/12 px-4">
                  <h4 class="text-3xl fonat-semibold text-blueGray-700">Let's make our comminity strong!</h4>
                  <h5 class="text-lg mt-0 mb-2 text-blueGray-600">
                    spread our culture across the world!
                  </h5>
                  <div class="mt-6 lg:mb-0 mb-6 flex gap-4 text-4xl">
                    <button>
                    <i class="fa-brands fa-twitter" style="color: #005eff;"></i>
                    </button>
                    <button>
                    <i class="fa-brands fa-instagram" style="color: #f23a7b;"></i>
                    </button>
                    <button>
                    <i class="fa-brands fa-facebook" style="color: #1a6eff;"></i>
                    </button>
                  </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                  <div class="flex flex-wrap items-top mb-6">
                    <div class="w-full lg:w-4/12 px-4 ml-auto">
                      <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Useful Links</span>
                      <ul class="list-unstyled">
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

      </div>

</body>

<script>
  $(document).ready(function () {
    $('.send_request').click(function (e) {
      e.preventDefault();
      var fname = $('.fname').val();
      var lname = $('.lname').val();
      var email = $('.email').val();
      var phone = $('.phone').val();
      var detail = $('.detail').val();

      $.ajax({
        type: "POST",
        url: "php/insert_request.php",
        data: {
          fname: fname,
          lname: lname,
          email: email,
          phone: phone,
          detail: detail
        },
        success: function (data) {
          alert("Request Accepted: " + data);
          location.reload();
        },
        failure: function (err) {
          alert("Error: " + err);
        }
      });
    });
  });
</script>

<script src="./js/searchScript.js"></script>
<script>
  function sendValue() {
    var inputValue = document.getElementById("inputFieldIndex").value;
    window.location.href = "events.php?value=" + encodeURIComponent(inputValue);
}
</script>

</html>