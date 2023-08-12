<?php
// Include your connection file
include 'connection.php';

if (isset($_GET['event_id'])) {
    $eventId = $_GET['event_id'];

    require 'connection.php';

    $status = '1';

    $sql = "UPDATE tbl_event SET status = ? WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $eventId);
    

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Approved Successfully !!!');
            window.location.href='approve_requests.php'; 
        </script>";
    } else {
        echo "Error";
    }
    

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>