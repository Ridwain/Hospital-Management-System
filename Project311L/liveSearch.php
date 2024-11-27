<?php
include "dbcon.php";
session_start();

function generateTableRows($result)
{
    $output = "";
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . htmlspecialchars($row['appointmentID']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['PatientID']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Full_name']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Address']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Birth_date']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Email']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Blood_grp']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Gender']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Appointment_date']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['Time_slot']) . "</td>";
        $output .= "</tr>";
    }
    return $output;
}

if (isset($_POST['input']) && isset($_SESSION['user_id'])) {
    $input = $_POST['input'];
    $user_id = $_SESSION['user_id'];

    // Fetch doctor ID from the session's user ID
    $query = $connection->prepare("SELECT ID FROM Doctor WHERE User_id = ?");
    $query->bind_param("s", $user_id);
    $query->execute();
    $result1 = $query->get_result();

    if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc();
        $doctor_id = $row1['ID'];

        $sql = $connection->prepare("
            SELECT 
                Patient.ID AS PatientID, 
                Patient.Full_name, 
                Patient.Address, 
                Patient.Birth_date, 
                Patient.Email, 
                Patient.Blood_grp, 
                Patient.Gender, 
                Appointment.ID AS appointmentID,
                Appointment.Appointment_date, 
                Appointment.Time_slot 
            FROM 
                Patient 
            INNER JOIN 
                Appointment 
            ON 
                Patient.ID = Appointment.Patient_id 
            WHERE 
                Appointment.Doctor_id = ? 
                AND (Patient.Full_name LIKE ? OR Patient.ID LIKE ?)
            LIMIT 10
        ");
        $searchInput = "%$input%";
        $sql->bind_param("sss", $doctor_id, $searchInput, $searchInput);
        $sql->execute();
        $result = $sql->get_result();

        // Check if results exist
        if ($result->num_rows > 0) {
            echo "<div class='container mt-4'>
                    <div class='table-responsive-lg table-responsive-md table-responsive-sm'>
                        <table class='table table-bordered table-striped'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Address</th>
                                    <th>Birth Date</th>
                                    <th>Email</th>
                                    <th>Blood Group</th>
                                    <th>Gender</th>
                                    <th>Appointment Date</th>
                                    <th>Time Slot</th>
                                </tr>
                            </thead>
                            <tbody>";
            echo generateTableRows($result);
            echo "        </tbody>
                        </table>
                    </div>
                </div>";
        } else {
            echo "<div class='container mt-4'>
                    <p class='text-center text-danger'>No patients with appointments found for this doctor.</p>
                </div>";
        }

        // Close statements
        $sql->close();
    } else {
        echo "<div class='container mt-4'>
                <p class='text-center text-danger'>Error: Doctor not found for this session.</p>
            </div>";
    }

    $query->close();
    $connection->close();
} else {
    echo "<div class='container mt-4'>
            <p class='text-center text-danger'>Error: Missing input or user session.</p>
        </div>";
}
