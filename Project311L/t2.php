<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="adminContent/addDoc.css" />

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <title>Doctor Registration</title>
</head>

<body>
    <section class="container">

        <header class="text-center mb-4">
            <h2>Doctor Registration Form</h2>
        </header>
        <form method="post" action="doctorRegister.php" class="form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input
                    type="text"
                    id="full_name"
                    class="form-control"
                    placeholder="Enter full name"
                    name="full_name"
                    required />

            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="Enter email address"
                    name="email"
                    required />
            </div>


            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input
                    type="tel"
                    id="phone_number"
                    class="form-control"
                    placeholder="01XXXXXXXXX"
                    pattern="[0-1]{2}[0-9]{9}"
                    name="phone_number"
                    required />
            </div>
            <div>
                <label for="b_date">Birth Date</label>
                <input
                    type="date"
                    id="b_date"
                    class="form-control"
                    placeholder="Enter birth date"
                    name="b_date"
                    required />
            </div>
            <div class="form-group">
                <label for="check-male">Gender</label>
                <br>
                <input
                    type="radio"
                    id="check-male"
                    name="gender"
                    value="Male"
                    checked style="width: 30px;" />
                <label for="check-male" class="form-check-label">Male</label>

                <input
                    type="radio"
                    id="check-female"
                    name="gender"
                    value="Female" style="width: 30px;" />
                <label for="check-female" class="form-check-label">Female</label>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input
                    type="text"
                    id="address"
                    class="form-control"
                    placeholder="Enter your address"
                    name="address"
                    required />
            </div>
            <div class="form-group">
                <label for="Specialities">Specialties</label>
                <select name="Specialities" id="Specialities" class="form-control" required>
                    <option value="">Select Specialization</option>
                    <?php
                    $query = "SELECT *  FROM Specialities ORDER BY Specialities ASC";
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
                <label for="user_type">User Type</label>
                <select name="user_type" id="user_type" class="form-control">
                    <option hidden>Select User Type</option>
                    <option>Doctor</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    class="form-control"
                    placeholder="Enter your password"
                    name="password"
                    required />
            </div>
            <br>
            <div class="form-group">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>

    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>