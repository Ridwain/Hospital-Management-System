<?php
include 'dbcon.php';
session_start();

if (isset($_POST['submit'])) {
  $Phone_Number = mysqli_real_escape_string($connection, $_POST['phoneNumber']);
  $Password = mysqli_real_escape_string($connection, $_POST['password']);

  $select = mysqli_query($connection, "SELECT * FROM `Admin` WHERE Phone_Number = '$Phone_Number' AND Password='$Password'") or die('query failed');

  if (mysqli_num_rows($select) > 0) {
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = 1; // Store user ID in the session
    header('Location: adminPortal.php');
    exit();
  } else {
    $message[] = 'Incorrect phone number or password!';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADMIN_LOGIN_PAGE</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="login.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />

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
  <div class="wrapper">
    <h1><strong>Admin</strong> Login</h1>
    <form action="" method="POST">
      <div class="input-box">
        <input type="text" placeholder="Phone Number" name="phoneNumber" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password" name="password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" class="btn" name="submit">Login</button>

      <?php if (isset($message)): ?>
        <p style="color:red;"><?php echo $message[0]; ?></p>
      <?php endif; ?>
      <div class="register-link">
        <p>Go Back To <a href="index.html">Home Page</a></p>
      </div>
    </form>
  </div>
</body>

</html>