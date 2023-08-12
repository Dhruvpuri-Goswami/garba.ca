<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");

    exit();
}

// Get the username from the session
$user_id = $_SESSION["user_id"];

// Connect to the database and fetch request details
require '../php/connection.php';

$sql_approved = "SELECT * FROM tbl_event WHERE user_id='$user_id' AND status='1'";
$result_approved = mysqli_query($conn, $sql_approved);
$approved = mysqli_num_rows($result_approved);

$sql_pending = "SELECT * FROM tbl_event WHERE user_id='$user_id' AND status='0'";
$result_pending = mysqli_query($conn, $sql_pending);
$pending = mysqli_num_rows($result_pending);

$sql_total = "SELECT * FROM tbl_event WHERE user_id='$user_id'";
$result_total = mysqli_query($conn, $sql_total);
$total = mysqli_num_rows($result_total);

$sql_completed = "SELECT * FROM tbl_event WHERE user_id='$user_id' AND status='1    ' AND event_end_date>date('Y-m-d')";
$result_completed = mysqli_query($conn, $sql_completed);
$completed = mysqli_num_rows($result_completed);

$sql = "SELECT * FROM tbl_event WHERE user_id='$user_id' LIMIT 4";
$result = mysqli_query($conn, $sql);
$requests = [];
while ($row = mysqli_fetch_assoc($result)) {
    $requests[] = $row;
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
                            href="#">
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
                                <a href="add_event.php"
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
                            href="#">
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
                                        class="fas fa-approve mr-3 text-base transform hover:scale-105 transition-transform duration-300"></i>
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
                        <b>Dashboard</b>
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
                class="flex flex-col flex-1 w-full overflow-y-auto p-5 bg-gradient-to-br from-gray-200 to-gray-100  shadow-md">
                <main>
                    <div class="grid px-8 bg-transparent h-full">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="grid grid-cols-12 col-span-12 gap-6 xxl:col-span-9">
                                <div class="col-span-12 mt-2">
                                    <div class="grid grid-cols-12 gap-6 mt-5">
                                        <a class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
                                            href="#">
                                            <div class="p-5">
                                                <div class="flex justify-between">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-7 w-7 text-yellow-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-2 w-full flex-1">
                                                    <div>
                                                        <div class="mt-3 text-3xl font-bold leading-8">
                                                            <?php echo $total; ?>
                                                        </div>

                                                        <div class="mt-1 text-base text-gray-600">Total Events</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
                                            href="#">
                                            <div class="p-5">
                                                <div class="flex justify-between">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-7 w-7 text-pink-600" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-2 w-full flex-1">
                                                    <div>
                                                        <div class="mt-3 text-3xl font-bold leading-8">
                                                            <?php echo $completed; ?>
                                                        </div>

                                                        <div class="mt-1 text-base text-gray-600">Completed Event</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
                                            href="#">
                                            <div class="p-5">
                                                <div class="flex justify-between">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-7 w-7 text-green-600" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor">
                                                        <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M8 12l3 3L18 9"></path>
                                                    </svg>


                                                </div>
                                                <div class="ml-2 w-full flex-1">
                                                    <div>
                                                        <div class="mt-3 text-3xl font-bold leading-8">
                                                            <?php echo $approved; ?>
                                                        </div>

                                                        <div class="mt-1 text-base text-gray-600">Approved Event</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
                                            href="#">
                                            <div class="p-5">
                                                <div class="flex justify-between">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-7 w-7 text-yellow-600" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor">
                                                        <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                                        <line x1="12" y1="6" x2="12" y2="12" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"></line>
                                                        <line x1="12" y1="12" x2="16" y2="14" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"></line>
                                                    </svg>

                                                </div>
                                                <div class="ml-2 w-full flex-1">
                                                    <div>
                                                        <div class="mt-3 text-3xl font-bold leading-8">
                                                            <?php echo $pending; ?>
                                                        </div>

                                                        <div class="mt-1 text-base text-gray-600">Pending Events</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-span-12 mt-5">
                                    <div class="grid gap-2 grid-cols-1 lg:grid-cols-1">
                                        <div class="bg-white p-4 shadow-lg rounded-lg">
                                            <h1 class=" text-gray-700 font-medium text-lg">
                                                Latest Events</h1>
                                            <div class="mt-4">
                                                <div class="flex flex-col">
                                                    <div class="-my-2 overflow-x-auto">
                                                        <div class="py-2 align-middle inline-block min-w-full">
                                                            <div
                                                                class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead>
                                                                        <tr class="bg-gray-100">
                                                                        <tr>
                                                                            <th
                                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                                <div class="flex cursor-pointer">
                                                                                    <span class="mr-2">Event Name</span>
                                                                                </div>
                                                                            </th>
                                                                            <th
                                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                                <div class="flex cursor-pointer">
                                                                                    <span class="mr-2">Location</span>
                                                                                </div>
                                                                            </th>
                                                                            <th
                                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                                <div class="flex cursor-pointer">
                                                                                    <span class="mr-2">STATUS</span>
                                                                                </div>
                                                                            </th>
                                                                            <th
                                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                                <div class="flex cursor-pointer">
                                                                                    <span class="mr-2">Artist
                                                                                        Name</span>
                                                                                </div>
                                                                            </th>
                                                                            <th
                                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                                <div class="flex cursor-pointer">
                                                                                    <span class="mr-2">Sponsors</span>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody
                                                                        class="bg-white divide-y divide-gray-200 hover:bg-gray-50">
                                                                        <?php $count = 1;
                                                                        foreach ($requests as $request): ?>
                                                                            <tr>
                                                                                <td
                                                                                    class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                                    <p>
                                                                                        <?php echo $request['event_name']; ?>
                                                                                    </p>
                                                                                </td>
                                                                                <td
                                                                                    class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                                    <p>
                                                                                        <?php echo $request['event_venue']; ?>
                                                                                    </p>
                                                                                </td>
                                                                                <td
                                                                                    class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                                    <div class="flex">
                                                                                        <?php
                                                                                        $status = $request['status'];
                                                                                        if ($status == '1') {
                                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>';
                                                                                            echo '<p class="text-green-500">Active</p>';
                                                                                        } elseif ($status == '0') {
                                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                <line x1="12" y1="6" x2="12" y2="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                <line x1="12" y1="12" x2="16" y2="14" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
            </svg>';
                                                                                            echo '<p class="text-yellow-500">Pending</p>';
                                                                                        } elseif ($status == '-1') {
                                                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>';
                                                                                            echo '<p class="text-red-500">Rejected</p>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </td>
                                                                                <td
                                                                                    class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                                    <p>
                                                                                        <?php
                                                                                        $eventid = $request['event_id'];
                                                                                        $artist_sql = "SELECT artist_name FROM tbl_artist WHERE event_id=?";
                                                                                        $stmt = $conn->prepare($artist_sql);
                                                                                        $stmt->bind_param("i", $eventid); // Assuming event_id is an integer
                                                                                        $stmt->execute();
                                                                                        $result = $stmt->get_result();

                                                                                        $artist_names = [];
                                                                                        while ($row = $result->fetch_assoc()) {
                                                                                            $artist_names[] = $row['artist_name'];
                                                                                        }
                                                                                        $stmt->close();

                                                                                        // Convert the array of artist names into a comma-separated string
                                                                                        $artist_string = implode(', ', $artist_names);

                                                                                        echo $artist_string;

                                                                                        ?>
                                                                                    </p>
                                                                                </td>
                                                                                <td
                                                                                    class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                                    <p>
                                                                                        <?php echo $request['event_sponsor']; ?>
                                                                                    </p>
                                                                                </td>

                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="text-right">
    <a href="history.php" class="inline-block bg-gray-700 hover:bg-yellow-600 text-white font-semibold py-2 px-4 mt-5 rounded shadow">Show More</a>
</div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
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


</body>

</html>