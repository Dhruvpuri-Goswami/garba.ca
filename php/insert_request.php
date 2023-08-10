<?php
include 'connection.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$detail = $_POST['detail'];

// Get the current date and time in MySQL format
$currentDate = date('Y-m-d');

$sql = "INSERT INTO tbl_request (first_name, last_name, phone_no, email_id, description, request_date)
VALUES ('$fname', '$lname', '$phone', '$email', '$detail', '$currentDate')";

if ($conn->query($sql) === TRUE) {
  echo "We will contact with you within the 72 hours!!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
