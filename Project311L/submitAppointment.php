<?php

include 'dbcon.php';
session_start();

if (isset($_POST['submit'])) {
    $Patient_id = $_POST['patient_id'];
    $Doctor_id = $_POST['doctor_id'];
    $Appointment_date = $_POST['date'];
    $Time_slot = $_POST['time_slot'];

    $timeSlotQuery = "SELECT Max_patient FROM Time_slots WHERE time_slot = '$Time_slot' AND doctor_id = '$Doctor_id'";
    $timeSlotResult = $connection->query($timeSlotQuery);

    if ($timeSlotResult->num_rows > 0) {
        $timeSlotRow = $timeSlotResult->fetch_assoc();
        $Max_patient = $timeSlotRow['Max_patient'];


        $appointmentCountQuery = "SELECT COUNT(*) AS booked_count FROM Appointment WHERE Appointment_date = '$Appointment_date' AND Time_slot = '$Time_slot' AND Doctor_id = '$Doctor_id'";
        $appointmentCountResult = $connection->query($appointmentCountQuery);

        if ($appointmentCountResult->num_rows > 0) {
            $appointmentCountRow = $appointmentCountResult->fetch_assoc();
            $bookedCount = $appointmentCountRow['booked_count'];


            if ($bookedCount < $Max_patient) {

                $query = "INSERT INTO `Appointment` (`ID`, `Patient_id`, `Doctor_id`, `Appointment_date`, `Time_slot`) 
                          VALUES (NULL, '$Patient_id', '$Doctor_id', '$Appointment_date', '$Time_slot')";

                if ($connection->query($query)) {
                    $_SESSION['status'] = "Hi , Your appoinment is scheduled according to your choosen date and time";
                    $_SESSION['status_code'] = "success";
                    header("location:patientPortal.php");
                }
            } else {
                $_SESSION['status'] = "Selected Time slot is fully booked.";
                $_SESSION['status_code'] = "error";
                header("location:patientPortal.php");
            }
        } else {
            echo "Error retrieving appointment count.";
        }
    } else {
        echo "Invalid time slot or doctor.";
    }
}
