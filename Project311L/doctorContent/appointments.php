<?php
include 'dbcon.php';

// Start the session
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: doctorLogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT ID FROM Doctor WHERE user_id='$user_id'";
$result = $connection->query($query);

if (!$result) {
    die("Error executing query: " . $connection->error);
}

if ($result && $result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
    $ID = $doctor['ID'];
} else {
    echo "No doctor found for the given user ID.";
    exit();
}
$tomorrow_date = date('Y-m-d', strtotime('+1 day'));
$sql = "SELECT a.ID, p.Full_name AS Patient_name, d.Full_name AS Doctor_name, a.Appointment_date, a.Time_slot, a.status
        FROM Appointment a
        JOIN Doctor d ON a.Doctor_id = d.ID
        JOIN Patient p ON a.Patient_id = p.ID
        WHERE a.Appointment_date = '$tomorrow_date' AND d.ID='$ID'";

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
    <title>Appointments</title>
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

        .status-select {
            width: 100%;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h2 class="text-center"><strong>Appointment List</strong></h2>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time Slot</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Patient_name']); ?></td>
                        <td>Dr. <?php echo htmlspecialchars($row['Doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Time_slot']); ?></td>
                        <td>
                            <form method="POST" action="updateStatus.php">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['ID']; ?>">
                                <select name="status" class="status-select">
                                    <option value="Scheduled" <?php echo $row['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                    <option value="Confirmed" <?php echo $row['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Canceled" <?php echo $row['status'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                        </td>
                        <td>
                            <button type="submit" name="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>

<?php

$connection->close();
?>