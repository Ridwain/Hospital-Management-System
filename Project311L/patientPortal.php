<?php
include 'dbcon.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: patientLogin.php");
  exit();
}

// Include different content based on the page selection
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient's Portal</title>
  <link rel="stylesheet" href="portal.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Sacramento&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,700&display=swap" rel="stylesheet">
  <script type="text/javascript">
    function preventBack() {
      window.history.forward();
    }
    setTimeout(preventBack, 0);
    window.onunload = function() {};
  </script>
</head>

<body>
  <!-- Header Section -->
  <header class="header">
    <h1>We Care Hospital</h1>
    <a href="pLogout.php" class="btn-logout">Log Out</a>
  </header>

  <!-- Sidebar Navigation -->
  <nav id="sidenav" class="sidenav">
    <h1 id="brandName">WCH</h1>
    <a href="?page=dashboard">Dashboard</a>
    <a href="?page=makeAppointment">Make Appointment</a>
    <a href="?page=appointments">Appointments List 🔍</a>

  </nav>

  <!-- Main Content Area -->
  <div id="main">
    <div id="content">
      <?php
      // Include content based on the selected page
      switch ($page) {
        case 'dashboard':
          include 'patientContent/dashboard.php';
          break;
        case 'makeAppointment':
          include 'patientContent/makeAppointment.php';
          break;
        case 'appointments':
          include 'patientContent/appointments.php';
          break;
        default:
          echo "<h2>Page not found</h2>";
      }
      ?>
    </div>
  </div>

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
        button: "OK",

      });
    </script>

  <?php
    unset($_SESSION['status']);
  }
  ?>
</body>

</html>
