<?php
include 'dbcon.php';
session_start();
if (isset($_POST['submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $appointment_id = intval($appointment_id); // Ensure it's an integer
    $status = mysqli_real_escape_string($connection, $status);


    $sql = "UPDATE `Appointment` SET `status` = '$status' WHERE `ID` = '$appointment_id'";
    if ($connection->query($sql)) {
        $_SESSION['status'] = "Updated  Successfully";
        $_SESSION['status_code'] = "success";
        header("location: doctorPortal.php");
    } else {
        $_SESSION['status'] = "Update Failed!";
        $_SESSION['status_code'] = "error";
    }
}
