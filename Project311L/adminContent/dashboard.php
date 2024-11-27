<?php
include 'dbcon.php';


$doctor_query = "SELECT COUNT(*) AS doctor_count FROM Users WHERE UserType = 'Doctor'";
$doctor_result = $connection->query($doctor_query);
$doctor_count = $doctor_result->fetch_assoc()['doctor_count'];

$patient_query = "SELECT COUNT(*) AS patient_count FROM Users WHERE UserType = 'Patient'";
$patient_result = $connection->query($patient_query);
$patient_count = $patient_result->fetch_assoc()['patient_count'];

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Statistics</title>
    <style>
        .container {
            display: flex;
            gap: 20px;
        }

        .card {
            width: 300px;
            background: linear-gradient(90deg, #206fdd, #00d2ff);
            color: white;
            border-radius: 12px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .card h2 {
            margin: 10px 0;
            font-size: 36px;
            color: #fff;
        }

        .card h4 {
            margin: 5px 0;
            font-size: 18px;
            color: #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="container">
        <article class="card">
            <img src="images/doctor.jpg" alt="Doctor Image">
            <h2><?php echo $doctor_count; ?></h2>
            <h4>Total Doctors</h4>
        </article>
        <article class="card">
            <img src="images/patient.jpg" alt="Patient Image">
            <h2><?php echo $patient_count; ?></h2>
            <h4>Total Patients</h4>
        </article>
    </div>
</body>

</html>