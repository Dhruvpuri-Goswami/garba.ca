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
        <a href="index.php">
          <h2 class="font-[Pacifico] rotate-8 text-[30px] text-yellow-600 hover:text-yellow-500 cursor-pointer">Garba</h2>
        </a>
      </div>
      <div>
        <input id="inputFieldEvent" type="text" class="searchBars w-[40vw] rounded-full pl-6" placeholder="Search | Event | Location">
      </div>
      <div class="text-[20px] flex gap-6 pr-3 ">
        <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-house"></i></a>
        <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-user"></i></a>

      </div>
    </nav>

    <div class="card py-3">

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
        <?php
        // Include your database connection file here
        include './php/connection.php';

        // Fetching all event details from the database
        $sql = "SELECT * FROM tbl_event LIMIT 4";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            ?>


            <div class="item-card relative mx-auto w-full">
              <a href="#"
                class=" relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full">
                <div class="shadow-md shadow-gray-300 p-4 rounded-lg bg-white">
                  <div class="flex justify-center relative rounded-lg overflow-hidden h-72">
                    <div class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full">
                      <div class="absolute inset-0 bg-black">
                      <?php
                          $imageLink = str_replace("../", "./", $row['event_poster']);
                          ?>
                          <img class="object-cover w-full h-full" src="<?php echo $imageLink; ?>" alt="Event Poster">
                      </div>
                    </div>

                  </div>

                  <!-- text section -->
                  <div class="py-4 font-[Quicksand]">
                    <h3 class="title text-2xl font-semibold mb-1 ">
                      <?php echo $row['event_name']; ?>
                    </h3>
                    <p class="loc text-sm text-gray-500 mb-1"> 
                    <i class="fa-solid fa-location-dot"></i>
                      <?php echo $row['event_venue']; ?>
                    </p>
                    <p class="text-sm text-gray-500 mb-1"> <i class="fa-solid fa-calendar-days"></i>
                      <?php echo $row['event_start_date'] . "-" . $row['event_end_date']; ?>
                    </p>
                    <p class="text-sm text-gray-500 mb-1"><i class="fa-solid fa-clock"></i>
                      <?php echo $row['event_start_time'] . "-" . $row['event_end_time']; ?>
                    </p>
                  </div>

                  <a href="mainCard.php?event_id=<?php echo $row['event_id']; ?>"
                    class=" block text-center bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition-colors duration-300">Book
                    Now</a>
                </div>
              </a>
            </div>

            <?php
          }
        }
        $conn->close();
        ?>

      </div>

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

<script src="./js/searchScript.js"> </script>
<script>
var urlParams = new URLSearchParams(window.location.search);
var valueFromIndex = urlParams.get('value');

document.getElementById("inputFieldEvent").value = valueFromIndex;
</script>

</body>

</html>