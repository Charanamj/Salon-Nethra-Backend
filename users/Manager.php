
<!DOCTYPE html>
<html lang="en">
<?php

if (($_SESSION ['userrole']) == 'Manager') {

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
        <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
          </form>
        </div>
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
                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= SYSTEM_PATH ?>logout.php">
                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
              <span class="count-symbol bg-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Messages</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="<?= SYSTEM_PATH ?>assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                  <p class="text-gray mb-0"> 1 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="<?= SYSTEM_PATH ?>assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                  <p class="text-gray mb-0"> 15 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="<?= SYSTEM_PATH ?>assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                  <p class="text-gray mb-0"> 18 Minutes ago </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">4 new messages</h6>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
              data-bs-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
              aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-calendar"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                  <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-cog"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                  <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-link-variant"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                  <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
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
              <i class="mdi md-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
              aria-controls="ui-basic">
              <span class="menu-title">Salon Services</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>services/addcategory.php">Add Service Category</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>services/addservices.php">Add Salon Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>services/editservices.php">Edit Salon Services</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false"
              aria-controls="icons">
              <span class="menu-title">Register with the System</span>
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
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false"
              aria-controls="icons">
              <span class="menu-title">Salon Customer Details</span>
              <i class="menu-arrow"></i>              
            </a>
            <div class="collapse" id="forms">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>customers/viewcustomer.php">Customer Details</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons1" aria-expanded="false" aria-controls="icons1">
              <span class="menu-title">Appointment Management</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons1">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>appointments/viewappointments.php">View Appointments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>appointments/completeappointments.php">Completed Appointments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>appointments/processingappointments.php">Processing Appointments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>appointments/cancelledappointments.php">Cancelled Appointments</a>
                </li>
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item">
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
          </li> -->
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <span class="menu-title">Salon Products</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/addproductcategory.php">Add Salon Products Categoty</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/addproductname.php">Add Salon Products Names</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/addproducts.php">Add Salon Products</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/addbatches.php">Add Batches for products</a>
                </li>               
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/viewproducts.php">View Salon Products</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>products/productstock.php">View Product Serial</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <span class="menu-title">Salon Payments</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>payments/addprices.php">Add Prices</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-title">Creating TIme Slots</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?= SYSTEM_PATH ?>timeslots/timeslot.php"> Adding Time Slot </a>
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