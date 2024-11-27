<?php
include 'dbcon.php';

if (isset($_POST['submit'])) {
    $Full_name = $_POST['fullName'];
    $Email = $_POST['email'];
    $Phone_Number = $_POST['phoneNumber'];
    $Birth_Date = $_POST['b_date'];
    $Gender = $_POST['gender'];
    $Address = $_POST['address'];
    $Blood_Grp = $_POST['bloodGrp'];
    $UserType = $_POST['userType'];
    $Password = $_POST['password'];
    $enc_Password = password_hash($Password, PASSWORD_DEFAULT);


    $checkNumber = "SELECT * FROM Users WHERE Phone_Number='$Phone_Number' ";

    $result = $connection->query($checkNumber);

    if ($result->num_rows > 0) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Phone Number Already Exists</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
            <style>
                body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    background-color: #f8f9fa;
                    font-family: Arial, sans-serif;
                }

                .message-box {
                    text-align: center;
                    border: 1px solid #ccc;
                    padding: 20px;
                    border-radius: 8px;
                    background-color: white;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    width: 100%;
                }
            </style>
        </head>

        <body>
            <div class="message-box">
                <h2>Phone Number Already Exists</h2>
                <p>The phone number you entered is already associated with an account.</p>
                <button onclick="window.history.back();" class="btn btn-primary mt-3">Go Back</button>
            </div>
        </body>

        </html>
<?php
    } else {
        $connection->begin_transaction();

        $insertQuery1 = "INSERT INTO `Users` (`ID`, `Phone_Number`, `Password`, `UserType`) 
                 VALUES (NULL, '$Phone_Number', '$enc_Password', '$UserType')";


        if ($connection->query($insertQuery1) === TRUE) {
            $user_id = $connection->insert_id;

            $insertQuery2 = "INSERT INTO `Patient` (`ID`, `Full_name`, `Email`, `Birth_date`, `Gender`, `Address`, `Blood_Grp`, `user_id`) 
                                VALUES (NULL, '$Full_name', '$Email', '$Birth_Date', '$Gender', '$Address', '$Blood_Grp', '$user_id')";


            if ($connection->query($insertQuery2) === TRUE) {
                $connection->commit();
                header("Location: patientLogin.php");
                exit;
            } else {
                $connection->rollback();
                echo "Error: " . $connection->error;
            }
        } else {
            $connection->rollback();
            echo "Error: " . $connection->error;
        }
    }
}
?>