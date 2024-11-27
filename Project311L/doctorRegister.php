<?php
include 'dbcon.php';
session_start();

if (isset($_POST['submit'])) {
    // Input data
    $Full_name = $_POST['full_name'];
    $Email = $_POST['email'];
    $Phone_Number = $_POST['phone_number'];
    $Birth_Date = $_POST['b_date'];
    $Gender = $_POST['gender'];
    $Address = $_POST['address'];
    $Specialities = $_POST['Specialities'];
    $UserType = $_POST['user_type'];
    $Password = $_POST['password'];
    $enc_Password = password_hash($Password, PASSWORD_DEFAULT);

    try {
        // Check if phone number exists
        $check_query = "SELECT * FROM Users WHERE Phone_Number = '$Phone_Number'";
        $result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['status'] = "Mobile Number Already Exists";
            $_SESSION['status_code'] = "error";
            header("location: adminPortal.php");
            exit;
        }

        // Start transaction
        mysqli_begin_transaction($connection);

        // Insert into Users table
        $insert_user_query = "INSERT INTO `Users` (`Phone_Number`, `Password`, `UserType`) 
                              VALUES ('$Phone_Number', '$enc_Password', '$UserType')";

        if (!mysqli_query($connection, $insert_user_query)) {
            throw new Exception("Error inserting into Users: " . mysqli_error($connection));
        }

        $user_id = mysqli_insert_id($connection);

        // Insert into Doctor table
        $insert_doctor_query = "INSERT INTO `Doctor` (`Full_name`, `Email`, `Birth_Date`, `Gender`, `Address`, `Specialities`, `User_id`) 
                                VALUES ('$Full_name', '$Email', '$Birth_Date', '$Gender', '$Address', '$Specialities', '$user_id')";

        if (!mysqli_query($connection, $insert_doctor_query)) {
            throw new Exception("Error inserting into Doctor: " . mysqli_error($connection));
        }

        // Commit transaction
        mysqli_commit($connection);

        $_SESSION['status'] = "Doctor successfully registered!";
        $_SESSION['status_code'] = "success";

        header("Location: adminPortal.php"); // Redirect to admin portal
        exit;
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($connection);
        $_SESSION['status'] = "Error: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
        header("Location: adminPortal.php");
        exit;
    }
}
