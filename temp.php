<?php
// Include your database connection file here
include './php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if request_id is set in the query string
    if (isset($_GET['requestId'])) {
        // $request_id = intval($_GET['requestId']); // Ensure it's an integer
        $request_id = base64_decode($_GET['requestId']);

        // Check if request_id exists in tbl_request
        $stmt_check = $conn->prepare("SELECT * FROM tbl_request WHERE request_id = ?");
        $stmt_check->bind_param("i", $request_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) { // If the request_id exists

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


                echo "New records created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Please verify the link.";
        }

        $stmt_check->close();
    } else {
        echo "Invalid request.";
    }
}

$conn->close();
?>