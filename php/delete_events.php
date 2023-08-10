<?php
if (isset($_POST['id'])) {
    $eventId = $_POST['id'];

    require 'connection.php';

    $sql = "DELETE FROM tbl_event WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Success";
    } else {
        echo "Error";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>