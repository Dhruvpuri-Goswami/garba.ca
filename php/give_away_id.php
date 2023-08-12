<?php
session_start();
require 'connection.php';
header('Content-Type: application/json');

$response = ["success" => false];

if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
    
    // First, update all events to set giveaway status to 0
    $resetStmt = $conn->prepare("UPDATE tbl_event SET give_away = 0");
    if (!$resetStmt->execute()) {
        $response["error"] = "Error resetting giveaway status.";
        echo json_encode($response);
        exit;
    }
    $resetStmt->close();

    // Now, update the selected event's giveaway status to 1
    $stmt = $conn->prepare("UPDATE tbl_event SET give_away = 1 WHERE event_id = ?");
    $stmt->bind_param('i', $eventId);
    
    if ($stmt->execute()) {
        $response["success"] = true;
    } else {
        $response["error"] = $stmt->error;
    }
    
    $stmt->close();
} else {
    $response["error"] = "Event ID is not provided.";
}

echo json_encode($response);
?>
