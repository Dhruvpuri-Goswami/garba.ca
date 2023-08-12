<?php
session_start();
include '../php/connection.php';

$event_id = $_GET['event_id'];

// Fetch the current event details, artists, and contacts
$stmt = $conn->prepare("SELECT * FROM tbl_event WHERE event_id=?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

$artists_result = $conn->query("SELECT artist_name FROM tbl_artist WHERE event_id=$event_id");
$artists = [];
while ($row = $artists_result->fetch_assoc()) {
    $artists[] = $row['artist_name'];
}

$contacts_result = $conn->query("SELECT contact_no FROM tbl_contact WHERE event_id=$event_id");
$contacts = [];
while ($row = $contacts_result->fetch_assoc()) {
    $contacts[] = $row['contact_no'];
}

if (isset($_POST['update'])) {


    $event_name = htmlspecialchars($_POST['event_name']);
    $event_start_date = htmlspecialchars($_POST['event_start_date']);
    $event_end_date = htmlspecialchars($_POST['event_end_date']);
    $event_host = htmlspecialchars($_POST['event_host']);
    $event_venue = htmlspecialchars($_POST['event_venue']);
    $event_start_time = htmlspecialchars($_POST['event_start_time']);
    $event_end_time = htmlspecialchars($_POST['event_end_time']);
    $event_sponsor = htmlspecialchars($_POST['event_sponsor']);
    $gmail = htmlspecialchars($_POST['gmail']);
    $event_desc = htmlspecialchars($_POST['event_desc']);
    $event_price = htmlspecialchars($_POST['event_price']);

    $event_artists = isset($_POST['event_artists']) ? explode(',', $_POST['event_artists']) : [];
    $event_contacts = isset($_POST['event_contacts']) ? explode(',', $_POST['event_contacts']) : [];

    $filename = $_FILES["event_poster"]["name"];
    $tempname = $_FILES["event_poster"]["tmp_name"];

    $folder_name = "../file_images/" . $filename;

    if ($_FILES["event_poster"]["error"] != UPLOAD_ERR_NO_FILE) {
        if (!move_uploaded_file($tempname, $folder_name)) {
            die('Error moving uploaded file. Check permissions and path.');
        }
    } else {
        $folder_name = $event['event_poster'];
    }


    move_uploaded_file($tempname, $folder_name);
    $status = 0;

    // Update the main event details
    $stmt = $conn->prepare("UPDATE tbl_event SET event_name=?, event_start_date=?, event_end_date=?, event_host=?, event_venue=?, event_start_time=?, event_end_time=?, event_sponsor=?, gmail=?, event_desc=?, event_poster=?, event_price=?, status=? WHERE event_id=?");
    $stmt->bind_param("sssssssssssssi", $event_name, $event_start_date, $event_end_date, $event_host, $event_venue, $event_start_time, $event_end_time, $event_sponsor, $gmail, $event_desc, $folder_name, $event_price, $status, $event_id);
    $stmt->execute();
    $stmt->close();

    // Update artists
    // First, delete all current artists for this event
    $conn->query("DELETE FROM tbl_artist WHERE event_id=$event_id");
    // Then, insert the updated artists
    $stmt_artist = $conn->prepare("INSERT INTO tbl_artist (event_id, artist_name) VALUES (?, ?)");
    foreach ($event_artists as $artist) {
        $trimmed_artist = trim($artist); // Ensure no leading/trailing whitespace
        $stmt_artist->bind_param("is", $event_id, $trimmed_artist);
        $stmt_artist->execute();
    }
    $stmt_artist->close();

    // Update contacts
    // First, delete all current contacts for this event
    $conn->query("DELETE FROM tbl_contact WHERE event_id=$event_id");
    // Then, insert the updated contacts
    $stmt_contact = $conn->prepare("INSERT INTO tbl_contact (event_id, contact_no) VALUES (?, ?)");
    foreach ($event_contacts as $contact) {
        $trimmed_contact = trim($contact); // Ensure no leading/trailing whitespace
        $stmt_contact->bind_param("is", $event_id, $trimmed_contact);
        $stmt_contact->execute();
    }
    $stmt_contact->close();

    echo "<script>alert(Event updated successfully!);</script>";
    header("Location: edit_event.php?event_id=" . $event_id);
}



?>


<!DOCTYPE html>
<html x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Pacifico&family=Quicksand&display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex h-screen bg-gray-800 " :class="{ 'overflow-hidden': isSideMenuOpen }">

        <aside class="z-20 flex-shrink-0 hidden w-64 pl-4 pr-4 overflow-y-auto bg-gray-900 md:block relative">
            <div class="py-4 text-white">
                <div class="flex justify-center mt-5 mb-8 flex-col items-center">
                    <h1
                        class="text-xl md:text-4xl font-[Abril] text-white transform hover:scale-105 transition-transform duration-300">
                        Garba</h1>
                    <p class="mt-1 text-sm md:text-lg text-yellow-500 font-[Pacifico]">
                        Tradition Alive!
                    </p>
                </div>

                <hr>
                <br>


                <ul class="space-y-3">
                    <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <a class="flex items-center text-base font-semibold text-white hover:text-yellow-600 transition-colors duration-200"
                            href="user_dashboard.php">
                            <i
                                class="fas fa-tachometer-alt mr-4 text-lg transform hover:rotate-12 transition-transform duration-300"></i>
                            DASHBOARD
                        </a>
                    </li>

                    <li x-data="{ open: false }">
                        <div @click="open = !open"
                            class="flex justify-between px-4 py-2 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors duration-200">
                            <span class="flex items-center text-base font-semibold text-white">
                                <i
                                    class="fas fa-calendar-alt mr-4 text-lg transform hover:scale-105 transition-transform duration-300"></i>
                                Events
                            </span>
                            <i :class="{'fas fa-chevron-up': open, 'fas fa-chevron-down': !open}"
                                class="text-lg transform hover:rotate-180 transition-transform duration-300"></i>
                        </div>

                        <ul x-show.transition.origin.top="open" class="space-y-2 mt-2 pl-8">
                            <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <a href="#"
                                    class="flex items-center text-sm font-semibold text-white hover:text-yellow-600 transition-colors duration-200">
                                    <i
                                        class="fas fa-plus-circle mr-3 text-base transform hover:rotate-90 transition-transform duration-300"></i>
                                    Add Events
                                </a>
                            </li>
                            <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <a href="approved_event.php"
                                    class="flex items-center text-sm font-semibold text-white hover:text-yellow-600 transition-colors duration-200">
                                    <i
                                        class="fas fa-clipboard-check mr-3 text-base transform hover:scale-105 transition-transform duration-300"></i>
                                    Approved Events
                                </a>
                            </li>
                            <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <a href="history.php"
                                    class="flex items-center text-sm font-semibold text-white hover:text-yellow-600 transition-colors duration-200">
                                    <i
                                        class="fas fa-history mr-3 text-base transform hover:scale-105 transition-transform duration-300"></i>
                                    History
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>

            </div>
            <ul class="absolute bottom-4 left-4 right-4 space-y-3">
                <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <a href="../logout.php"
                        class="flex items-center text-base font-semibold text-white hover:text-red-400 transition-colors duration-200">
                        <i
                            class="fas fa-sign-out-alt mr-4 text-lg transform hover:scale-105 transition-transform duration-300"></i>
                        LOGOUT
                    </a>
                </li>
            </ul>
        </aside>


        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>

        <aside
            class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-gray-900 dark:bg-gray-800 md:hidden flex flex-col"
            x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
            @keydown.escape="closeSideMenu">
            <div class="flex-1 py-4 text-white">
                <div class="flex justify-center mb-8 flex-col items-center">
                    <h1
                        class="text-xl md:text-4xl font-[Abril] text-white transform hover:scale-105 transition-transform duration-300">
                        Garba</h1>
                    <p class="mt-1 text-sm md:text-lg text-yellow-500 font-[Pacifico]">
                        Tradition Alive!
                    </p>
                </div>

                <hr>
                <br>

                <ul class="space-y-3">
                    <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <a class="flex items-center text-base font-semibold text-white hover:text-yellow-600 transition-colors duration-200"
                            href="user_dashboard.php">
                            <i
                                class="fas fa-tachometer-alt mr-4 text-lg transform hover:rotate-12 transition-transform duration-300"></i>
                            DASHBOARD
                        </a>
                    </li>

                    <li x-data="{ open: false }">
                        <div @click="open = !open"
                            class="flex justify-between px-4 py-2 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors duration-200">
                            <span class="flex items-center text-base font-semibold text-white">
                                <i
                                    class="fas fa-calendar-alt mr-4 text-lg transform hover:scale-105 transition-transform duration-300"></i>
                                Events
                            </span>
                            <i :class="{'fas fa-chevron-up': open, 'fas fa-chevron-down': !open}"
                                class="text-lg transform hover:rotate-180 transition-transform duration-300"></i>
                        </div>

                        <ul x-show.transition.origin.top="open" class="space-y-2 mt-2 pl-8">
                            <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <a href="#"
                                    class="flex items-center text-sm font-semibold text-white hover:text-yellow-600 transition-colors duration-200">
                                    <i
                                        class="fas fa-plus-circle mr-3 text-base transform hover:rotate-90 transition-transform duration-300"></i>
                                    Add Events
                                </a>
                            </li>
                            <li class="px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <a href="#"
                                    class="flex items-center text-sm font-semibold text-white hover:text-yellow-600 transition-colors duration-200">
                                    <i
                                        class="fas fa-history mr-3 text-base transform hover:scale-105 transition-transform duration-300"></i>
                                    History
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>

            </div>

            <div class="bg-gray-800 py-2">
                <a href="../logout.php"
                    class="block px-4 py-2 rounded hover:bg-gray-700 transition-colors duration-200 flex items-center text-white hover:text-red-600">
                    <i
                        class="fas fa-sign-out-alt text-lg transform hover:scale-105 transition-transform duration-300"></i>
                    <span class="ml-4">LOGOUT</span>
                </a>
            </div>
        </aside>


        <div class="flex flex-col flex-1 w-full overflow-y-auto">
            <header class="z-40 py-4 bg-gradient-to-br from-gray-200 to-gray-100 shadow-md">
                <div class="container mx-auto flex items-center justify-between h-8 px-6">

                    <!-- Mobile Menu Icon -->
                    <button class="p-1 rounded-md md:hidden focus:outline-none hover:bg-gray-300"
                        @click="toggleSideMenu" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                d="M4 6h16M4 12h8m-8 6h16"></path>
                        </svg>
                    </button>

                    <!-- Logo for Desktop and Mobile -->
                    <div class="text-gray-700 font-medium text-lg">
                        <b>ADD EVENTS</b>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-700">Hello,
                            <?php echo $_SESSION['user_name']; ?>!
                        </span>
                        <a href="../logout.php"
                            class="p-2 bg-gray-700 rounded-full w-8 h-8 hover:bg-gray-700 transition-colors duration-200 text-white hover:text-yellow-600 flex items-center justify-center">
                            <i
                                class="fas fa-sign-out-alt text-sm transform hover:scale-105 transition-transform duration-300"></i>
                        </a>
                    </div>


                </div>
            </header>

            <div
                class="flex flex-col flex-1 w-full overflow-y-auto p-5 bg-gradient-to-br from-gray-200 to-gray-100 shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-[62%,35%] gap-8">
                    <div class="col-span-1">
                        <form id="event-form" method="post" action="" enctype="multipart/form-data"
                            onsubmit="return confirmChanges()">
                            <div class="w-full space-y-8 p-5 bg-white rounded-xl shadow-lg z-10">
                                <h2 class="text-xl font-semibold">Event Details</h2>
                                <hr style="margin-top:10px;margin-bottom:-15px">
                                <div class="grid gap-8 grid-cols-1">
                                    <div class="flex flex-col">
                                        <div class="">
                                            <div class="form">
                                                <div class="md:space-y-2 mb-3">
                                                    <label class="text-l font-semibold text-gray-600 py-2">Please enter
                                                        your event
                                                        details<abbr class="hidden" title="required">*</abbr></label>
                                                </div>
                                                <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                                                    <div class="mb-3 space-y-2 w-full text-xs">
                                                        <label class="font-semibold text-gray-600 py-2">Enter event name
                                                        </label>
                                                        <input placeholder="Event Name"
                                                            class="appearance-none block mb-24 w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                                            required="required" type="text" name="event_name"
                                                            id="event_name" value="<?php echo $event['event_name']; ?>">
                                                        <p class="text-red text-xs hidden">Please fill out this field.
                                                        </p>
                                                        <div class="flex items-center py-6">
                                                            <label class="cursor-pointer ">
                                                                <label class="font-semibold text-gray-600 py-2">Upload
                                                                    event
                                                                    poster</label>
                                                                <span
                                                                    class="focus:outline-none text-white ml-5 text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Browse</span>
                                                                <input type="file" name="event_poster" class="hidden"
                                                                    value="../<?php echo $event['event_poster']; ?>">
                                                            </label>
                                                        </div>
                                                        <!-- New Input Fields -->
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label class="font-semibold text-gray-600 mb-2">Event
                                                                    Date
                                                                    Range</label>
                                                                <div class="flex space-x-2">
                                                                    <input type="date" name="event_start_date"
                                                                        placeholder=""
                                                                        class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                        value="<?php echo $event['event_start_date']; ?>">
                                                                    <span class="text-lg">to</span>
                                                                    <input type="date" name="event_end_date"
                                                                        placeholder="3rd August"
                                                                        class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                        value="<?php echo $event['event_end_date']; ?>">
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="font-semibold text-gray-600">Host
                                                                    Name</label>
                                                                <input type="text" name="event_host"
                                                                    placeholder="Host Name"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo $event['event_host']; ?>">
                                                            </div>

                                                            <!-- For multiple artists -->
                                                            <div>
                                                                <label class="font-semibold text-gray-600">Artists
                                                                    (comma
                                                                    separated)</label>
                                                                <input type="text" name="event_artists"
                                                                    placeholder="Artist1, Artist2, ..."
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo implode(', ', $artists); ?>">
                                                            </div>

                                                            <!-- For multiple contacts -->
                                                            <div>
                                                                <label class="font-semibold text-gray-600">Contact
                                                                    Numbers
                                                                    (comma separated)</label>
                                                                <input type="text" name="event_contacts"
                                                                    placeholder="1234567890, 0987654321, ..."
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo implode(', ', $contacts); ?>">
                                                            </div>

                                                            <div>
                                                                <label class="font-semibold text-gray-600">Venue</label>
                                                                <input type="text" name="event_venue"
                                                                    placeholder="Venue"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo $event['event_venue']; ?>">
                                                            </div>

                                                            <div>
                                                                <label class="font-semibold text-gray-600">Price</label>
                                                                <input type="number" name="event_price"
                                                                    placeholder="Price"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo $event['event_price']; ?>">
                                                            </div>

                                                            <div class="space-y-8">
                                                                <div>
                                                                    <label
                                                                        class="font-semibold text-gray-600">Time</label>
                                                                    <div class="flex space-x-2">
                                                                        <input type="time" name="event_start_time"
                                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                            value="<?php echo $event['event_start_time']; ?>">
                                                                        <span>to</span>
                                                                        <input type="time" name="event_end_time"
                                                                            class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                            value="<?php echo $event['event_end_time']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="font-semibold text-gray-600">Sponsored
                                                                    By</label>
                                                                <input type="text" name="event_sponsor"
                                                                    placeholder="Sponsored By"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo $event['event_sponsor']; ?>">
                                                            </div>

                                                            <div>
                                                                <label class="font-semibold text-gray-600">Gmail</label>
                                                                <input type="email" name="gmail" placeholder="Gmail"
                                                                    class="w-full h-10 px-4 rounded-lg border border-gray-300"
                                                                    value="<?php echo $event['gmail']; ?>">
                                                            </div>
                                                        </div>
                                                        <!-- End of New Input Fields -->

                                                        <div class="flex-auto w-full mb-1 text-xs space-y-2">
                                                            <label
                                                                class="font-semibold text-gray-600 py-2">Description</label>
                                                            <textarea required="" name="event_desc" id=""
                                                                class="w-full min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
                                                                placeholder="Enter your company info"
                                                                spellcheck="false"><?php echo htmlspecialchars($event['event_desc']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="text-xs text-red-500 text-right my-3">Required fields are
                                                    marked
                                                    with
                                                    an
                                                    asterisk <abbr title="Required field">*</abbr></p>
                                                <div
                                                    class="mt-5 text-right md:space-x-3 md:block flex flex-col-reverse">
                                                    <button
                                                        class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                                        Cancel </button>
                                                    <button
                                                        class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500"
                                                        type="submit" name="update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-1">
                        <div id="preview-section" class="bg-white p-5 rounded-xl shadow-lg h-full">
                            <h2 class="text-xl font-semibold mb-3">Event Preview</h2>
                            <hr>
                            <div id="preview-content" class="text-gray-600 space-y-4 m-3">

                                <h3 class="text-2xl font-bold">
                                    <?php echo htmlspecialchars($event['event_name']); ?>
                                </h3>
                                <img id="event-poster-preview" class="w-full object-cover rounded-md shadow-lg mb-4"
                                    src="<?php echo $event['event_poster']; ?>" alt="Event Poster">

                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Description</h4>
                                    <p id="desc-preview">
                                        <?php echo htmlspecialchars($event['event_desc']); ?>
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <p><strong class="font-semibold">Host:</strong> <span id="host-preview">
                                            <?php echo htmlspecialchars($event['event_host']); ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Date:</strong> <span id="date-preview">
                                            <?php echo $event['event_start_date'] . " to " . $event['event_end_date']; ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Time:</strong> <span id="time-preview">
                                            <?php echo $event['event_start_time'] . " to " . $event['event_end_time']; ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Artists:</strong> <span id="artists-preview">
                                            <?php echo implode(", ", $artists); ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Contacts:</strong> <span id="contacts-preview">
                                            <?php echo implode(", ", $contacts); ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Venue:</strong> <span id="venue-preview">
                                            <?php echo htmlspecialchars($event['event_venue']); ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Price:</strong> $<span id="price-preview">
                                            <?php echo $event['event_price']; ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Sponsored By:</strong> <span id="sponsor-preview">
                                            <?php echo htmlspecialchars($event['event_sponsor']); ?>
                                        </span></p>
                                    <p><strong class="font-semibold">Email:</strong> <span id="email-preview">
                                            <?php echo htmlspecialchars($event['gmail']); ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                function data() {

                    return {

                        isSideMenuOpen: false,
                        toggleSideMenu() {
                            this.isSideMenuOpen = !this.isSideMenuOpen
                        },
                        closeSideMenu() {
                            this.isSideMenuOpen = false
                        },
                        isNotificationsMenuOpen: false,
                        toggleNotificationsMenu() {
                            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
                        },
                        closeNotificationsMenu() {
                            this.isNotificationsMenuOpen = false
                        },
                        isProfileMenuOpen: false,
                        toggleProfileMenu() {
                            this.isProfileMenuOpen = !this.isProfileMenuOpen
                        },
                        closeProfileMenu() {
                            this.isProfileMenuOpen = false
                        },
                        isPagesMenuOpen: false,
                        togglePagesMenu() {
                            this.isPagesMenuOpen = !this.isPagesMenuOpen
                        },

                    }
                }
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    let form = document.getElementById('event-form');

                    function updatePreview() {
                        if (form.event_poster.files[0]) {
                            let imageUrl = URL.createObjectURL(form.event_poster.files[0]);
                            document.getElementById('event-poster-preview').style.display = 'block';
                            document.getElementById('event-poster-preview').src = imageUrl;
                        }

                        document.querySelector('#preview-content h3').textContent = form.event_name.value;
                        document.getElementById('host-preview').textContent = form.event_host.value;
                        document.getElementById('date-preview').textContent = `${form.event_start_date.value} to ${form.event_end_date.value}`;
                        document.getElementById('time-preview').textContent = `${form.event_start_time.value} to ${form.event_end_time.value}`;
                        document.getElementById('artists-preview').textContent = form.event_artists.value;
                        document.getElementById('contacts-preview').textContent = form.event_contacts.value;
                        document.getElementById('venue-preview').textContent = form.event_venue.value;
                        document.getElementById('price-preview').textContent = form.event_price.value;
                        document.getElementById('sponsor-preview').textContent = form.event_sponsor.value;
                        document.getElementById('email-preview').textContent = form.gmail.value;
                        document.getElementById('desc-preview').textContent = form.event_desc.value;
                    }

                    form.addEventListener('input', updatePreview);

                });


            </script>
            <script>
                function confirmChanges() {
                    return confirm('If you change the content, your event will be sent again to the admin for approval. Do you want to continue?');
                }
            </script>


</body>

</html>