<?php
include 'dbcon.php';
session_start();

if (isset($_POST['submit'])) {
    $specialities = trim($_POST['Specialities']);

    // Validate input: ensure it's not empty or just spaces
    if (empty($specialities)) {
        $_SESSION['status'] = "Speciality cannot be empty.";
        $_SESSION['status_code'] = "error";
    } else {
        // Check if the speciality already exists
        $query = "SELECT * FROM `Specialities` WHERE `Specialities` = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $specialities);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['status'] = "Specialty already exists.";
            $_SESSION['status_code'] = "error";
        } else {
            // Insert new specialization into database
            $insert_query = "INSERT INTO `Specialities` (`Specialities`) VALUES (?)";
            $stmtInsert = $connection->prepare($insert_query);
            $stmtInsert->bind_param("s", $specialities);

            if ($stmtInsert->execute()) {
                $_SESSION['status'] = "Specialization added successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error adding specialization.";
                $_SESSION['status_code'] = "error";
            }
        }
    }
    header("Location: adminPortal.php"); // Redirect back to the form
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Specialization</title>
    <style>
        #hTitle {
            width: 100%;
            font-size: 3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;

            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            max-width: 500px;
            width: 50%;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: black;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
    </style>
</head>

<body>
    <h1 id="hTitle">Add Specialization</h1>
    <br><br>
    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="Specialities">Specialties</label>
                <input type="text" id="Specialities" class="form-control" placeholder="Enter Specialties" name="Specialities" required />
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>