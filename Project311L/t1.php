<?php
include 'dbcon.php';
if (isset($_POST['submit'])) {
    $specialities = $_POST['Specialities'];

    $query = "SELECT * FROM `Specialities` WHERE `Specialities`='$specialities'";
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0) {
        $_SESSION['status'] = "Already Exists";
        $_SESSION['status_code'] = "error";;
    } else {
        $insert_query = "INSERT INTO `Specialities` (`ID`,`Specialities`) VALUES (NULL,'$specialities')";
        if ($connection->query($insert_query)) {
            $_SESSION['status'] = "Specialization Added Successfully";
            $_SESSION['status_code'] = "success";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <br>
    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="Specialities">Specialities</label>
                <input
                    type="text"
                    id="Specialities"
                    class="form-control"
                    placeholder="Enter Specialities"
                    name="Specialities"
                    pattern=".*\S.*"
                    title="This field cannot contain only spaces."
                    required />
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>