<?php

session_start();
include 'dbcon.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['user_id'])) {
    header('Location: doctorLogin.php');
    exit();
}


$user_id = $_SESSION['user_id'];


$query = "SELECT 
                Doctor.ID As doctor_id, 
                Doctor.Full_name As doctor_name, 
                Doctor.Email As doctor_email,
                Doctor.Birth_date As doctor_birthdate,
                Users.Phone_Number As doctor_phone_number, 
                Doctor.Gender As doctor_gender,
                Doctor.Address As doctor_address,
                Doctor.Specialities As doctor_specialities
          FROM 
                Doctor
          JOIN 
                Users 
          ON 
                Doctor.User_id = Users.ID 
          WHERE 
                Users.ID = '$user_id'";


$result = $connection->query($query);

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    echo "Doctor information not found.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <title>Doctor Dashboard</title>
    <style>
        th {
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            color: white;
        }

        td {
            font-weight: 550;
        }
    </style>
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
        <h2 class="text-center"><strong>Hello, Dr. <?php echo htmlspecialchars($doctor['doctor_name']); ?></strong></h2>
        <br><br>
        <h3 class="text-muted">Doctor's <span class="text-primary">Info</span></h3>
        <div class="table-responsive mt-4">
            <table class="table table-bordered details-table">
                <thead class="thead-light">
                    <tr>
                        <th colspan="4" class="text-center">Doctor Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><strong>Name</strong></th>
                        <td>Dr. <?php echo htmlspecialchars($doctor['doctor_name']); ?></td>
                        <th><strong>Email</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_email']); ?></td>
                    </tr>
                    <tr>
                        <th><strong>Birth Date</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_birthdate']); ?></td>
                        <th><strong>Address</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_address']); ?></td>
                    </tr>
                    <tr>
                        <th><strong>Gender</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_gender']); ?></td>
                        <th><strong>Speciality</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_specialities']); ?></td>
                    </tr>
                    <tr>
                        <th><strong>Phone Number</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_phone_number']) ?></td>
                        <th><strong>Doctor ID</strong></th>
                        <td><?php echo htmlspecialchars($doctor['doctor_id']) ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>