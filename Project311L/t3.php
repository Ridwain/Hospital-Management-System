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
        $stmtCheck = $connection->prepare("SELECT * FROM Users WHERE Phone_Number = ?");
        $stmtCheck->bind_param("s", $Phone_Number);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['status'] = "Mobile Number Already Exists";
            $_SESSION['status_code'] = "error";
            header("location: adminPortal.php");
            exit;
        }

        // Start transaction
        $connection->begin_transaction();

        // Insert into Users table
        $stmtInsertUser = $connection->prepare(
            "INSERT INTO `Users` (`Phone_Number`, `Password`, `UserType`) VALUES (?, ?, ?)"
        );
        $stmtInsertUser->bind_param("sss", $Phone_Number, $enc_Password, $UserType);

        if (!$stmtInsertUser->execute()) {
            throw new Exception("Error inserting into Users: " . $stmtInsertUser->error);
        }

        $user_id = $connection->insert_id;

        // Insert into Doctor table
        $stmtInsertDoctor = $connection->prepare(
            "INSERT INTO `Doctor` (`Full_name`, `Email`, `Birth_date`, `Gender`, `Address`, `Specialities`, `User_id`) 
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmtInsertDoctor->bind_param(
            "ssssssi",
            $Full_name,
            $Email,
            $Birth_Date,
            $Gender,
            $Address,
            $Specialities,
            $user_id
        );

        if (!$stmtInsertDoctor->execute()) {
            throw new Exception("Error inserting into Doctor: " . $stmtInsertDoctor->error);
        }

        // Commit transaction
        $connection->commit();

        $_SESSION['status'] = "Registered Successfully";
        $_SESSION['status_code'] = "success";
        header("location: adminPortal.php");
        exit;
    } catch (Exception $e) {
        $connection->rollback();
        error_log($e->getMessage()); // Log the error for debugging
        $_SESSION['status'] = "An error occurred. Please try again.";
        $_SESSION['status_code'] = "error";
        header("location: adminPortal.php");
        exit;
    }
}
