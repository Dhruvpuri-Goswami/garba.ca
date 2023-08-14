<?php
// Include the database connection
include './php/connection.php';
// Fetching event details
$sql = "SELECT * FROM tbl_event WHERE give_away='1' LIMIT 1";
$result = $conn->query($sql);

// Initialize event_id variable
$event_id = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event_id = $row['event_id'];
    }
}
// Check if the form has been submitted
if (isset($_POST['submit_form'])) {
    // Capture the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['Number'];
    $event_id = $_POST['event_id'];

    // Validate the data (basic validation)
    if (empty($name) || empty($email) || empty($contact_no) || empty($event_id)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Check if the record already exists in the database
        $sql_check_duplicate = "SELECT * FROM tbl_giveaway WHERE email = ? AND event_id = ?";
        if ($stmt_check = $conn->prepare($sql_check_duplicate)) {
            $stmt_check->bind_param('si', $email, $event_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo "<script>alert('Duplicate data! You have already participated in this giveaway.');</script>";
            } else {
                // Prepare the SQL statement to insert data into the database
                $sql_insert = "INSERT INTO tbl_giveaway(name, email, contact_no, event_id) VALUES (?, ?, ?, ?)";

                // Use prepared statements for better security
                if ($stmt = $conn->prepare($sql_insert)) {
                    // Bind the parameters
                    $stmt->bind_param('sssi', $name, $email, $contact_no, $event_id);

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "<script>alert('Thanks for participating!'); window.location.href = 'index.php';
                        </script>";
                    } else {
                        echo "<script>alert('Error: " . $stmt->error . "');</script>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "<script>alert('Error: " . $conn->error . "');</script>";
                }
            }

            // Close the statement
            $stmt_check->close();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Pacifico&family=Quicksand&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Giveaway | Garba</title>
</head>
<!-- component -->

<body>
    <section class="min-h-screen flex items-stretch text-white ">
        <div class="lg:flex w-1/2 hidden bg-gray-800 bg-no-repeat bg-cover relative items-center"
            style="background-image: url(./content/Images/garba1.webp);">
            <div class="absolute bg-black opacity-90 inset-0 z-0"></div>
            <?php
            // Fetching all event details from the database
            $sql = "SELECT * FROM tbl_event WHERE give_away='1' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="w-full px-24 z-10">
                        <h2 class="text-4xl font-[Quicksand] py-0 font-bold  tracking-wide mb-1">
                            <?php echo $row['event_name']; ?>
                        </h2>
                        <p class="font-[Quicksand] text-2xl py-0 mt-3"><i class="fa-solid fa-location-dot mr-2"></i>
                            <?php echo $row['event_venue']; ?>
                        </p>
                        <p class="mt-3 mb-5 font-thin"> Join us for an unforgettable night of joy, music, and celebration as we
                            dance
                            to the beats of traditional Garba music.</p>
                        <a href="mainCard.php?event_id=<?php echo $row['event_id']; ?>"
                            class="hover:underline transition-all duration-150 text-yellow-400 text-2xl py-4 italic hover:text-yello-700 ">View
                            Event</a>
                    </div>
                    <div class="bottom-0 absolute p-4 text-center right-0 left-0 flex justify-center space-x-4">
                        <span>
                            <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </span>
                        <span>
                            <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </span>
                        <span>
                            <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </span>
                    </div>
                </div>
                <?php
                }
            }
            ?>
        <div class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0"
            style="background-color: #161616;">
            <div class=" h-[150vh] absolute lg:hidden object-cover z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center"
                style="background-image: url(./content/Images/garba1.webp);">
                <div class="absolute bg-black opacity-90 inset-0 z-0"></div>
            </div>
            <div class=" w-full z-20">
                <div class="relative top-4 md:top-12 ">
                    <h1 class="text-[25vw] relative bottom-6  md:text-[10vw]  font-[Abril] ">Garba</h1>
                    <p class=" text-2xl relative bottom-14 md:bottom-20 md:text-3xl text-yellow-500 font-[Pacifico]">
                        Giveaway!</p>
                </div>

                <?php
                $sql = "SELECT * FROM tbl_event WHERE give_away='1' LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $event_id = $row['event_id'];
                        ?>

                        <div
                            class="eventDetails md:hidden block bg-white w-[80vw] rounded-md mx-auto text-black p-4 mb-2 shadow-md">
                            <h2 class="text-2xl font-[Quicksand] py-0 font-bold  tracking-wide mb-1">
                                <?php echo $row['event_name']; ?>
                            </h2>
                            <p class="font-[Quicksand] py-0"><i class="fa-solid fa-location-dot"></i>
                                <?php echo $row['event_venue']; ?>
                            </p>
                            <a href="mainCard.php?event_id=<?php echo $row['event_id']; ?>"
                                class="bg-yellow-500 text-white px-6 py-2 mt-6 rounded-full hover:bg-yellow-600 focus:outline-none">View
                                Event</a>
                        </div>
                        <?php
                    }
                }
                ?>
                <p class="text-gray-100 hover:text-yellow-500 uppercase  pt-5">
                    Fill Your Detail
                </p>
                <form action="" method="post" class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto">
                    <div class="pb-2 pt-4">
                        <input type="text" name="name" id="name" placeholder="Name"
                            class="block w-full p-4 text-lg rounded-sm bg-black">
                    </div>
                    <div class="pb-2 pt-4">
                        <input type="email" name="email" id="email" placeholder="Email"
                            class="block w-full p-4 text-lg rounded-sm bg-black">
                    </div>
                    <div class="pb-2 pt-4">
                        <input class="block w-full p-4 text-lg rounded-sm bg-black" type="number" name="Number"
                            id="Number" placeholder="Contact number">
                    </div>
                    <div class="pb-2 pt-4">
                        <input class="block w-full p-4 text-lg rounded-sm bg-black" type="hidden" name="event_id"
                            value="<?php echo $event_id; ?>" id="event_id">

                    </div>
                    <div class="px-4 pb-2 pt-4">
                        <button name="submit_form" type="submit"
                            class="uppercase block w-full p-4 text-lg rounded-full bg-yellow-500 hover:bg-yellow-600 focus:outline-none">Participate</button>
                    </div>
                </form>

                <div class="p-4 text-center right-0 left-0 flex justify-center space-x-4 mt-16 lg:hidden ">
                    <a href="#">
                        <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>