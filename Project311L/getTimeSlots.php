<?php
include 'dbcon.php';

if (isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];

    // Query the database to get available time slots for the selected doctor
    $query = "SELECT Time_slot FROM Time_slots WHERE Doctor_id='$doctor_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Time Slot</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . htmlspecialchars($row['Time_slot']) . "'>" . htmlspecialchars($row['Time_slot']) . "</option>";
        }
    } else {
        echo "<option value=''>No available time slots</option>";
    }
}
