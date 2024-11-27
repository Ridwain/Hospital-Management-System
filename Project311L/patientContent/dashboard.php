<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: patientLogin.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$query = "SELECT  
                Patient.ID AS patient_id, 
                Patient.Full_name AS patient_name, 
                Patient.Email AS patient_email,
                Patient.Birth_date AS patient_birthdate,
                Patient.Gender AS patient_gender,
                Patient.Address AS patient_address,
                Patient.Blood_Grp AS patient_blood_grp,
                Users.Phone_Number AS patient_phone_number,
                Patient.user_id AS patient_user_id
          FROM 
                Patient
          JOIN 
                Users 
          ON 
                Patient.User_id = Users.ID 
          WHERE 
                Users.ID = '$user_id'";

$result = $connection->query($query);

if ($result && $result->num_rows > 0) {
    // Fetch the row data
    $patient = $result->fetch_assoc();
} else {
    echo "Patient information not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <title>Patient Dashboard</title>
    <script type="text/javascript">
        function preventBack() {
            window.history.forward()
        };
        setTimeout("preventBack()", 0);
        window.onunload = function() {
            null;
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Hello, <?php echo htmlspecialchars($patient['patient_name']); ?></h2>
        <br><br>
        <h3 class="text-muted">Patient's <span class="text-primary">Info</span></h3>

        <div class="table-responsive mt-4">
            <table class="table table-bordered details-table">
                <thead class="thead-light">
                    <tr>
                        <th colspan="4" class="text-center">Patient Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_name']); ?></td>
                        <td><strong>Email</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_email']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Birth Date</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_birthdate']); ?></td>
                        <td><strong>Gender</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_gender']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_address']); ?></td>
                        <td><strong>Blood Group</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_blood_grp']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_phone_number']); ?></td>
                        <td><strong>Patient ID</strong></td>
                        <td><?php echo htmlspecialchars($patient['patient_id']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>