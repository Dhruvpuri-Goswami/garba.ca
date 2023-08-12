<?php

session_start();
require 'connection.php';
header('Content-Type: application/json');

$response = ["success" => false];

if (isset($_POST['eventIds']) && is_array($_POST['eventIds'])) {
    $eventIds = $_POST['eventIds'];
    $placeholders = implode(',', array_fill(0, count($eventIds), '?'));
    
    $stmt = $conn->prepare("UPDATE tbl_event SET is_featured = 1 WHERE event_id IN ($placeholders)");
    
    $stmt->bind_param(str_repeat('i', count($eventIds)), ...$eventIds);
    
    if ($stmt->execute()) {
        $response["success"] = true;
    } else {
        $response["error"] = $stmt->error;
    }
    

    $stmt->close();
} else {
    $response["error"] = "Event IDs are not provided or not in correct format.";
}

echo json_encode($response);

?>
