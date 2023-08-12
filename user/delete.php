<?php

include '../php/connection.php';  

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $stmt = $conn->prepare("DELETE FROM tbl_event WHERE event_id = ?");

    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting event. Please try again.');</script>";
    }

    $stmt->close();

    header("Location: user_dashboard.php");  
    exit;
} else {
    echo "<script>alert('No event specified for deletion.');</script>";
    header("Location: user_dashboard.php");  
    exit;
}

?>
