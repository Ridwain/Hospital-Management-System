<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {

    $id = intval($_POST['ID']); // Ensures it's an integer

    $query = "DELETE FROM Time_slots WHERE ID = $id";

    if ($connection->query($query) === TRUE) {
        header("Location: doctorPortal.php?success=1");
    } else {

        header("Location: doctorPortal.php?error=1");
    }
} else {

    header("Location: doctorPortal.php");
}

// Close the database connection
$conn->close();
