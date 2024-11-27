<?php
// Include your database connection
include('dbcon.php');

// Check if specialization is provided
if (isset($_POST['specialization'])) {
    $specialization = $_POST['specialization'];

    // Prepare and execute the query to get doctors based on specialization
    $stmt = $connection->prepare("SELECT ID, Full_name FROM Doctor WHERE Specialities = ?");
    $stmt->bind_param("s", $specialization);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any doctors are found
    if ($result->num_rows > 0) {
        echo '<option value="">Select Doctor</option>'; // Default option
        // Loop through doctors and return options
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Full_name']) . '</option>';
        }
    } else {
        echo '<option value="">No doctors available</option>';
    }
    $stmt->close();
} else {
    echo '<option value="">Select Doctors</option>';
}
