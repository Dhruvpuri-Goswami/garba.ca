<?php
    // Include your connection file
    include 'connection.php';

    // Get the request ID and status from the AJAX call
    $requestId = $_POST['id'];
    $status = $_POST['status'];

    // Construct an SQL query to update the status
    $sql = "UPDATE tbl_request SET status = $status WHERE request_id = $requestId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Request status updated successfully.";
    } else {
        echo "Error updating request: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
?>
