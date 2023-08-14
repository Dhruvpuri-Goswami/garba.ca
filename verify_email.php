<?php

include './php/connection.php';

if(isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE token = ?");
    $stmt->bind_param("s", $token);

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        // Token found, set is_verified to 1
        $update_stmt = $conn->prepare("UPDATE tbl_user SET is_verified = 1 WHERE token = ?");
        $update_stmt->bind_param("s", $token);
        $update_stmt->execute();
        header("Location: login.php");
    } else {
        echo "Invalid verification link or email already verified.";
    }
} else {
    echo "Invalid verification link.";
}

?>
