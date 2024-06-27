<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<?php include '../function.php'; ?>
<?php include '../config.php'; ?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    $db = dbConn();
    $sql = "UPDATE tbl_appointments SET appointment_status= '$appointment_status' WHERE appointment_id='$appointment_id'";

    $db->query($sql);
    header ("Location:viewappointments.php?status=activate");
}
?>