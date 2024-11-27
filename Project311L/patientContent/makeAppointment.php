<?php
include 'dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT ID,Full_name,Email FROM Patient WHERE user_id='$user_id'";
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        $patient_id = $patient['ID'];
        $patient_name = $patient['Full_name'];
        $patient_email = $patient['Email'];
    }
} else {

    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="patientContent/style2.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Appointment Form</title>
</head>

<body>
    <div class="container mt-5">
        <header class="mb-4">
            <h1 class="text-center"><strong>Appointment Form</strong></h1>
        </header>

        <form method="POST" action="submitAppointment.php">
            <div class="form-group">
                <label for="patient_id">Patient ID</label>
                <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Enter Patient ID" value="<?php echo htmlspecialchars($patient_id); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="patient_name">Patient Name</label>
                <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Enter Patient Name" value="<?php echo htmlspecialchars($patient_name); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="patient_email">Patient Email</label>
                <input type="email" class="form-control" id="patient_email" name="patient_email" placeholder="Enter Patient Email" value="<?php echo htmlspecialchars($patient_email); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="Specialities">Specialization</label>
                <select name="Specialities" id="Specialities" class="form-control" onchange="getDoctor(this.value)" required>
                    <option value="">Select Specialization</option>
                    <?php
                    $query = "SELECT * FROM Specialities ORDER BY Specialities ASC";
                    $result = mysqli_query($connection, $query);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . htmlspecialchars($row['Specialities']) . "'>" . htmlspecialchars($row['Specialities']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>Error loading specializations</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Full_name">Doctor Name</label>
                <select id="Full_name" name="Full_name" class="form-control" onchange="setDoctorId(this)" required>
                    <option value="">Select Doctor</option>
                </select>
            </div>

            <div class="form-group">
                <label for="doctor_id">Doctor ID</label>
                <input type="text" class="form-control" id="doctor_id" name="doctor_id" placeholder="Doctor ID" required readonly>
            </div>

            <div class="form-group">
                <label for="date">Appointment Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="time_slot">Time Slot</label>
                <select name="time_slot" id="time_slot" class="form-control" required>
                    <option value="">Select Time Slot</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function getDoctor(specialization) {
            if (specialization) {
                $.ajax({
                    url: 'getdoctor.php',
                    type: 'POST',
                    data: {
                        specialization: specialization
                    },
                    success: function(response) {
                        // Update doctor name options
                        $('#Full_name').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching doctors: ', error);
                    }
                });
            } else {
                $('#Full_name').html('<option value="">Select Doctor</option>');
                $('#doctor_id').val(''); // Clear doctor ID when no doctor is selected
            }
        }

        function setDoctorId(selectElement) {
            // Get the selected doctor's ID and set it in the input field
            var doctorId = $(selectElement).val();
            $('#doctor_id').val(doctorId); // Set the doctor ID input field

            if (doctorId) {
                $.ajax({
                    url: 'getTimeSlots.php',
                    type: 'POST',
                    data: {
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        $('#time_slot').html(response); // Update time slot options
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching time slots: ', error);
                    }
                });
            } else {
                $('#time_slot').html('<option value="">Select Time Slot</option>'); // Clear time slots if no doctor selected
            }
        }

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate() + 1).padStart(2, '0');

        const minDate = `${yyyy}-${mm}-${dd}`;

        // Set the min attribute of the date input
        document.getElementById('date').min = minDate;
    </script>
</body>

</html>