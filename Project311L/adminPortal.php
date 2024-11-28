<?php
include 'dbcon.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: doctorLogin.php");
  exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin's Portal</title>
  <link rel="stylesheet" href="portal.css">
  <!-- Bootstrap 4 and Custom Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Sacramento&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,700&display=swap" rel="stylesheet">




</head>

<body>
  <!-- Header Section -->
  <header class="header">
    <h1>Welcome to Admin Portal</h1>
    <a href="adminLogout.php" class="btn-logout">Log Out</a>
  </header>

  <!-- Sidebar Navigation -->
  <nav id="sidenav">
    <h1 id="brandName">WCH</h1>
    <a href="?page=dashboard" class="btn btn-link">Dashboard</a>
    <a href="?page=addDoctor" class="btn btn-link">Add Doctors</a>
    <a href="?page=addSpecialization" class="btn btn-link">Add Specialization</a>
  </nav>

  <!-- Main Content Area -->
  <div id="main">
    <div id="content">
      <!-- Page-specific Content -->

      <?php
      // Load content based on the selected page
      switch ($page) {
        case 'dashboard':
          include 'adminContent/dashboard.php';
          break;
        case 'addDoctor':
          include 'adminContent/addDoctor.php';
          break;
        case 'addSpecialization':
          include 'adminContent/addSpecialization.php';
          break;
        default:
          echo "<h2>Page not found</h2>";
      }
      ?>

      <!-- External Scripts -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <?php
      if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
      ?>
        <script>
          Swal.fire({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            confirmButtonText: "OK",
          });
        </script>
      <?php
        unset($_SESSION['status']);
      }
      ?>
    </div>
  </div>
</body>

</html>
