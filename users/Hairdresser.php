
<!DOCTYPE html>
<html lang="en">
<?php

if (($_SESSION ['userrole']) == 'Hairdresser') {

}else{
  header("Location: " . SYSTEM_PATH . "login.php");
}
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Salon Management System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/font-awesome/css/font-awesome.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?= SYSTEM_PATH ?>assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?= SYSTEM_PATH ?>assets/images/favicon.png" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="<?= SYSTEM_PATH ?>index.php"><img
            src="<?= SYSTEM_PATH ?>assets/images/logo.svg" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="<?= SYSTEM_PATH ?>index.html"><img
            src=" <?= SYSTEM_PATH ?>assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="nav-profile-img">
                <?php
                $db = dbConn();
                $staffpersonimage = $_SESSION['LogImg'];
                $sql = "SELECT * FROM  tbl_staff WHERE staff_image='$staffpersonimage'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc()
                ?>
                <img src="<?= SYSTEM_PATH ?>assets/images/staff/<?= $row['staff_image'] ?>" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">Hairdresser</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-cached me-2 text-success"></i> Profile </a>
            </div>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="<?= SYSTEM_PATH ?>logout.php">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
            <div class="nav-profile-image">
                <?php
                $db = dbConn();
                $staffpersonimage = $_SESSION['LogImg'];
                $sql = "SELECT * FROM  tbl_staff WHERE staff_image='$staffpersonimage'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc()
                  ?>
                <img src="<?= SYSTEM_PATH ?>assets/images/staff/<?= $row['staff_image'] ?>" alt="profile" />
                <span class="login-status online"></span>
              </div>
              <div class="nav-profile-text d-flex flex-column">            
                <?php
                $db = dbConn();
                $staffperson = $_SESSION['LogId'];
                $sql = "SELECT * FROM  tbl_staff WHERE staff_id='$staffperson'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc()
                ?>
                <span class="font-weight-bold mb-2"><?= $row['staff_firstname'] . ' ' . $row['staff_lastname'] ?></span>
                <?php
                $db = dbConn();
                $staffdesignation = $_SESSION['LogDesignation'];
                $sql = "SELECT * FROM  designation WHERE designation_id='$staffdesignation'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc()
                ?>
                <span class="text-secondary text-small"><?= $row['designation_name'] ?></span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
              aria-controls="ui-basic">
              <span class="menu-title">Appointments</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>appointments/viewBAappointments.php">My Appointments</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false"
              aria-controls="icons">
              <span class="menu-title">Request Salon Products</span>
              <i class="menu-arrow"></i>              
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>staff/registerstaff.php">Request a Product</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>staff/adddesigantion.php">Request Equipments</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
</body>

</html>