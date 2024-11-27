<?php
include 'dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT ID FROM Doctor WHERE user_id='$user_id'";
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
        $ID = $doctor['ID'];
    }
}
if (isset($_POST['submit'])) {

    $slot_start_hour = (int) $_POST['slot_start_hour'];
    $slot_start_minute = (int) $_POST['slot_start_minute'];
    $slot_start_am_pm = $_POST['slot_start_am_pm'];

    $slot_end_hour = (int) $_POST['slot_end_hour'];
    $slot_end_minute = (int) $_POST['slot_end_minute'];
    $slot_end_am_pm = $_POST['slot_end_am_pm'];

    $Doctor_id = (int) $_POST['doctor_id'];
    $Max_patients = (int) $_POST['max_patients'];

    $start_time = sprintf('%02d:%02d %s', $slot_start_hour, $slot_start_minute, $slot_start_am_pm);
    $end_time = sprintf('%02d:%02d %s', $slot_end_hour, $slot_end_minute, $slot_end_am_pm);

    $start_timestamp = strtotime($start_time);
    $end_timestamp = strtotime($end_time);

    if ($end_timestamp <= $start_timestamp) {
        $error_message = "End time must be after start time.";
    } else {
        $query_check = "SELECT * FROM `Time_slots` WHERE `Doctor_id` = '$Doctor_id'";
        $result = $connection->query($query_check);

        $overlap = false;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $existing_slot = $row['Time_slot'];
                list($existing_start, $existing_end) = explode(' - ', $existing_slot);

                $existing_start_timestamp = strtotime($existing_start);
                $existing_end_timestamp = strtotime($existing_end);

                if (
                    ($start_timestamp >= $existing_start_timestamp && $start_timestamp < $existing_end_timestamp) || // Overlaps at the start
                    ($end_timestamp > $existing_start_timestamp && $end_timestamp <= $existing_end_timestamp) || // Overlaps at the end
                    ($start_timestamp <= $existing_start_timestamp && $end_timestamp >= $existing_end_timestamp) // Encloses the existing slot
                ) {
                    $overlap = true;
                    break;
                }
            }
        }

        if ($overlap) {
            $error_message = "The time slot overlaps with an existing time slot.";
        } else {
            $query_insert = "INSERT INTO `Time_slots` (`ID`, `Doctor_id`, `Time_slot`, `Max_patient`) 
                             VALUES (NULL, '$Doctor_id', '$start_time - $end_time', '$Max_patients')";

            if ($connection->query($query_insert) === TRUE) {
                $success_message = "Time slot added successfully!";
            } else {
                $error_message = "Error: " . $connection->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointment Slot</title>
    <style>
        .addTitle {
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
        }
    </style>
    <link rel="stylesheet" href="doctorContent/timeslots.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div>
        <h1 class="addTitle text-center">Add Your Appointment Time Slots</h1>
    </div>
    <div class="container mt-5">
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } elseif (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form id="appointment-form" method="POST" action="">
            <div class="form-group">
                <label for="slot_start_time1">Select Slot Start Time:</label>
                <input
                    type="number"
                    id="slot_start_time1"
                    name="slot_start_hour"
                    min="1"
                    max="12"
                    placeholder="Hour"
                    required />
                <input
                    type="number"
                    id="slot_start_time2"
                    name="slot_start_minute"
                    min="0"
                    max="59"
                    placeholder="Minute"
                    required />
                <select id="slot_start_am_pm" name="slot_start_am_pm" required>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="slot_end_time1">Select Slot End Time:</label>
                <input
                    type="number"
                    id="slot_end_time1"
                    name="slot_end_hour"
                    min="1"
                    max="12"
                    placeholder="Hour"
                    required />
                <input
                    type="number"
                    id="slot_end_time2"
                    name="slot_end_minute"
                    min="0"
                    max="59"
                    placeholder="Minute"
                    required />
                <select id="slot_end_am_pm" name="slot_end_am_pm" required>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="doctor_id">Doctor ID:</label>
                <input type="number" id="doctor_id" name="doctor_id" value="<?php echo htmlspecialchars($ID); ?>" readonly />
            </div>
            <div class="form-group">
                <label for="max_patients">Max Patients:</label>
                <input
                    type="number"
                    id="max_patients"
                    name="max_patients"
                    min="1"
                    required
                    pattern=".*\S.*"
                    title="This field cannot contain only spaces." />
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <br><br>
    <div class="container">
        <h1 class="addTitle text-center">Delete Your Appointment Time Slots</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor ID</th>
                    <th>Time Slot</th>
                    <th>Max Patients</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbcon.php';
                $user_id = $_SESSION['user_id'];
                $query = "SELECT ID FROM Doctor WHERE user_id='$user_id'";
                $result1 = $connection->query($query);
                $row1 = $result1->fetch_assoc();
                $doc_id = $row1['ID'];
                $sql = "SELECT ID, Doctor_id, Time_slot, Max_patient FROM Time_slots WHERE Doctor_id='$doc_id'";
                $result = $connection->query($sql);
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['ID'] ?></td>
                            <td><?= $row['Doctor_id'] ?></td>
                            <td><?= $row['Time_slot'] ?></td>
                            <td><?= $row['Max_patient'] ?></td>
                            <td>
                                <form method="POST" action="deleteSlot.php" style="display:inline;">
                                    <input type="hidden" name="ID" value="<?= $row['ID'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No time slots found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


</body>

</html>