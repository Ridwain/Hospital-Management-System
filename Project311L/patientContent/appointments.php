<?php
include 'dbcon.php';


session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: patientLogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT ID FROM Patient WHERE user_id='$user_id'";
$result = $connection->query($query);

if (!$result) {
    die("Error executing query: " . $connection->error);
}

if ($result && $result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    $patient_id = $patient['ID'];
} else {
    echo "No patient found for the given user ID.";
    exit();
}

$sql = "SELECT a.ID, d.Full_name AS Doctor_name, a.Appointment_date, a.Time_slot, a.status
        FROM Appointment a
        JOIN Doctor d ON a.Doctor_id = d.ID
        WHERE a.Patient_id = '$patient_id'";

$result = $connection->query($sql);

if (!$result) {
    die("Error executing query: " . $connection->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            color: white;
        }

        td {
            font-weight: 550;
        }
    </style>
</head>

<body>
    <h2 class="text-center"><strong>My Appointment List</strong></h2>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time Slot</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>Dr. <?php echo htmlspecialchars($row['Doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Time_slot']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>

<?php
$connection->close();
?>