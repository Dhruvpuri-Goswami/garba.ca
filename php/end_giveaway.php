<?php
// end_giveaway.php

require 'connection.php';

$response = ['success' => false];

// Update the give_away field in the database to 0
$sql = "UPDATE tbl_event SET give_away = 0 WHERE give_away = 1";
if (mysqli_query($conn, $sql)) {
    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
