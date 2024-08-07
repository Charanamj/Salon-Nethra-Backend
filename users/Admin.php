<!DOCTYPE html>
<html lang="en">
<?php
//userrole eka log wena user ge harida balanwa

if (($_SESSION['userrole']) == 'Admin') {

} else {
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
              <?php
                $db = dbConn();
                $staffperson = $_SESSION['LogId'];
                $sql = "SELECT * FROM  tbl_staff WHERE staff_id='$staffperson'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc()
              ?>
                <p class="mb-1 text-black"><?= $row['staff_firstname'] ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-cached me-2 text-success"></i> Edit Proflie </a>
            </div>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="<?= SYSTEM_PATH ?>logout.php">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
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
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <!-- methandi api variaable ekak create karagannawa eka ata login page eke thiyena relevant session eka equal karagena qery eka liyanawa -->
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
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <span class="menu-title">User Registration</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>staff/registerstaff.php">Salon Staff Registration</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>staff/adddesigantion.php">Adding Staff Designation</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>staff/viewstaff.php">View Salon Staff Details</a>
                </li>
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <span class="menu-title">Icons</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/icons/font-awesome.html">Font Awesome</a>
                </li>
              </ul>
            </div>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
              <span class="menu-title">Forms</span>
              <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
            <div class="collapse" id="forms">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/forms/basic_elements.html">Form Elements</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <span class="menu-title">Charts</span>
              <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/charts/chartjs.html">ChartJs</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <span class="menu-title">Tables</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/tables/basic-table.html">Basic table</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-lock menu-icon"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/samples/blank-page.html"> Blank Page </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/samples/login.html"> Login </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/samples/register.html"> Register </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/samples/error-404.html"> 404 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?> pages/samples/error-500.html"> 500 </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= SYSTEM_PATH ?> docs/documentation.html" target="_blank">
              <span class="menu-title">Documentation</span>
              <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
          </li>
        </ul>
      </nav>
</body>

</html>