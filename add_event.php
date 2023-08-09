<?php
// Include your database connection file here
include './php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if request_id is set in the query string
    if (isset($_GET['requestId'])) {
        $request_id = base64_decode($_GET['requestId']);

        // Check if request_id exists in tbl_request
        $stmt_check = $conn->prepare("SELECT * FROM tbl_request WHERE request_id = ?");
        $stmt_check->bind_param("i", $request_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) { // If the request_id exists

            $event_name = $_POST['event_name'];
            $event_start_date = $_POST['event_start_date'];

            // Check for duplicate event_name and event_start_date
            $stmt_duplicate = $conn->prepare("SELECT * FROM tbl_event WHERE request_id = ?");
            $stmt_duplicate->bind_param("i", $request_id);

            $stmt_duplicate->execute();
            $duplicate_result = $stmt_duplicate->get_result();
            if ($duplicate_result->num_rows > 0) {
                echo "<script>alert('You can't place this event, it's already in the system!');</script>";
                $stmt_duplicate->close();
                return; // Exit from the script
            }
            $stmt_duplicate->close();

            $event_name = $_POST['event_name'];
            $event_start_date = $_POST['event_start_date'];
            $event_end_date = $_POST['event_end_date'];
            $event_host = $_POST['event_host'];
            $event_venue = $_POST['event_venue'];
            $event_start_time = $_POST['event_start_time'];
            $event_end_time = $_POST['event_end_time'];
            $event_sponsor = $_POST['event_sponsor'];
            $gmail = $_POST['gmail'];
            $event_desc = $_POST['event_desc'];
            $event_price = $_POST['event_price'];
            $event_artists = isset($_POST['event_artists']) ? explode(',', $_POST['event_artists']) : [];
            $event_contacts = isset($_POST['event_contacts']) ? explode(',', $_POST['event_contacts']) : [];
            $filename = $_FILES["event_poster"]["name"];
            $tempname = $_FILES["event_poster"]["tmp_name"];
            $folder_name = "file_images/" . $filename;
            move_uploaded_file($tempname, $folder_name);

            // Insert data into tbl_event
            $stmt = $conn->prepare("INSERT INTO tbl_event (request_id, event_name, event_start_date, event_end_date, event_host, event_venue, event_start_time, event_end_time, event_sponsor, gmail, event_desc, event_poster, event_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("issssssssssss", $request_id, $event_name, $event_start_date, $event_end_date, $event_host, $event_venue, $event_start_time, $event_end_time, $event_sponsor, $gmail, $event_desc, $folder_name, $event_price);


            if ($stmt->execute()) {
                $event_id = $conn->insert_id;

                // For the artists
                foreach ($event_artists as $artist) {
                    $trimmed_artist = trim($artist);
                    $stmt_artist = $conn->prepare("INSERT INTO tbl_artist (event_id, artist_name) VALUES (?, ?)");
                    $stmt_artist->bind_param("is", $event_id, $trimmed_artist);
                    $stmt_artist->execute();
                    $stmt_artist->close();
                }

                // For the contacts
                foreach ($event_contacts as $contact) {
                    $trimmed_contact = trim($contact);
                    $stmt_contact = $conn->prepare("INSERT INTO tbl_contact (event_id, contact_no) VALUES (?, ?)");
                    $stmt_contact->bind_param("is", $event_id, $trimmed_contact);
                    $stmt_contact->execute();
                    $stmt_contact->close();
                }

                echo "<script>alert('New records created successfully');</script>";

            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();

        } else {
            echo "<script>alert('Please verify the link.');</script>";

        }

        $stmt_check->close();
    } else {
        echo "<script>alert('Invalid request.');</script>";

    }
}

$conn->close();
?>

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
    <title>Add Event | Garba.ca</title>
</head>

<body class="h-[100vh] w-[100vw] bg-gray-100 ">
    <div class="main-container md:max-w-[80vw]  mx-auto shadow-lg px-6 bg-white max-w-full ">
        <nav class="w-full bg-white h-20 flex justify-between items-center text-2xl pt-4 ">
            <div>
                <h2 class="font-[Pacifico] rotate-8 text-[30px] text-yellow-600 hover:text-yellow-500 cursor-pointer">
                    Garba</h2>
            </div>
            <div>
                <input type="text" class="w-[40vw] rounded-full pl-6" placeholder="Search | Event | Location">
            </div>
            <div class="text-[20px] flex gap-6 pr-3 ">
                <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-house"></i></a>
                <a href="#" class="hover:text-yellow-500 transition duration-300"><i class="fas fa-user"></i></a>

            </div>
        </nav>


        <div class="card pt-16 shadow-md p-12">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="relative min-h-screen flex items-center justify-center bg-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 bg-gray-500 bg-no-repeat bg-cover relative items-center"
                    style="background-image: url(./content/Images/garba3.webp);">
                    <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
                    <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
                        <div class="grid  gap-8 grid-cols-1">
                            <div class="flex flex-col ">
                                <div class="flex flex-col sm:flex-row items-center">
                                    <h2 class="text-5xl mr-auto font-[Pacifico] text-yellow-500">Garba</h2>
                                    <div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
                                </div>
                                <div class="mt-5">
                                    <div class="form">
                                        <div class="md:space-y-2 mb-3">
                                            <label class="text-xs font-semibold text-gray-600 py-2">Add Details<abbr
                                                    class="hidden" title="required">*</abbr></label>
                                            <div class="flex items-center py-6">
                                                <label class="cursor-pointer ">
                                                    <label class="font-semibold text-gray-600 py-2">Upload event poster
                                                        * </label>
                                                    <span
                                                        class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Browse</span>
                                                    <input type="file" name="event_poster" class="hidden">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                                            <div class="mb-3 space-y-2 w-full text-xs">
                                                <label class="font-semibold text-gray-600 py-2">Enter event name <abbr
                                                        title="required">*</abbr></label>
                                                <input placeholder="Event Name"
                                                    class="appearance-none block mb-24 w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                                    required="required" type="text" name="event_name" id="event_name">
                                                <p class="text-red text-xs hidden">Please fill out this field.</p>

                                                <!-- New Input Fields -->
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="font-semibold text-gray-600 mb-2">Event Date
                                                            Range</label>
                                                        <div class="flex space-x-2">
                                                            <input type="date" name="event_start_date" placeholder=""
                                                                class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                            <span class="text-lg">to</span>
                                                            <input type="date" name="event_end_date"
                                                                placeholder="3rd August"
                                                                class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="font-semibold text-gray-600">Host Name</label>
                                                        <input type="text" name="event_host" placeholder="Host Name"
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>

                                                    <!-- For multiple artists -->
                                                    <div>
                                                        <label class="font-semibold text-gray-600">Artists (comma
                                                            separated)</label>
                                                        <input type="text" name="event_artists"
                                                            placeholder="Artist1, Artist2, ..."
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>

                                                    <!-- For multiple contacts -->
                                                    <div>
                                                        <label class="font-semibold text-gray-600">Contact Numbers
                                                            (comma separated)</label>
                                                        <input type="text" name="event_contacts"
                                                            placeholder="1234567890, 0987654321, ..."
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>




                                                    <div>
                                                        <label class="font-semibold text-gray-600">Venue</label>
                                                        <input type="text" name="event_venue" placeholder="Venue"
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>

                                                    <div>
                                                        <label class="font-semibold text-gray-600">Price</label>
                                                        <input type="number" name="event_price" placeholder="Price"
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>

                                                    <div class="space-y-8">
                                                        <div>
                                                            <label class="font-semibold text-gray-600">Time</label>
                                                            <div class="flex space-x-2">
                                                                <input type="time" name="event_start_time"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                                <span>to</span>
                                                                <input type="time" name="event_end_time"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="font-semibold text-gray-600">Sponsored By</label>
                                                        <input type="text" name="event_sponsor"
                                                            placeholder="Sponsored By"
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>

                                                    <div>
                                                        <label class="font-semibold text-gray-600">Gmail</label>
                                                        <input type="email" name="gmail" placeholder="Gmail"
                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300">
                                                    </div>
                                                </div>
                                                <!-- End of New Input Fields -->

                                                <div class="flex-auto w-full mb-1 text-xs space-y-2">
                                                    <label class="font-semibold text-gray-600 py-2">Description</label>
                                                    <textarea required="" name="event_desc" id=""
                                                        class="w-full min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
                                                        placeholder="Enter your company info"
                                                        spellcheck="false"></textarea>
                                                    <p class="text-xs text-gray-400 text-left my-3">You inserted 0
                                                        characters</p>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-xs text-red-500 text-right my-3">Required fields are marked with
                                            an
                                            asterisk <abbr title="Required field">*</abbr></p>
                                        <div class="mt-5 text-right md:space-x-3 md:block flex flex-col-reverse">
                                            <button
                                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                                Cancel </button>
                                            <button
                                                class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500"
                                                type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>

        </div>



        <div class=" md:mt-12">
            <footer class="relative bg-blueGray-200 pb-6 pt-4">
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
                                    <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Useful
                                        Links</span>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                                                href="https://www.creative-tim.com/presentation?ref=njs-profile">About
                                                Us</a>
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
                                    <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Other
                                        Resources</span>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                                                href="https://github.com/creativetimofficial/notus-js/blob/main/LICENSE.md?ref=njs-profile">MIT
                                                License</a>
                                        </li>
                                        <li>
                                            <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                                                href="https://creative-tim.com/terms?ref=njs-profile">Terms &amp;
                                                Conditions</a>
                                        </li>
                                        <li>
                                            <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                                                href="https://creative-tim.com/privacy?ref=njs-profile">Privacy
                                                Policy</a>
                                        </li>
                                        <li>
                                            <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm"
                                                href="https://creative-tim.com/contact-us?ref=njs-profile">Contact
                                                Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-6 border-blueGray-300 ">
                    <div class="flex flex-wrap items-center md:justify-between justify-center">
                        <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                            <div class="text-sm text-blueGray-500 font-semibold py-1">
                                Copyright © <span id="get-current-year">2021</span><a
                                    href="https://www.creative-tim.com/product/notus-js"
                                    class="text-blueGray-500 hover:text-gray-800" target="_blank"> Garba.ca
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