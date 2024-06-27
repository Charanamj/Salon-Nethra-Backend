<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<?php include '../function.php'; ?>
<?php include '../config.php'; ?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'activate') {
    $db = dbConn();
    $sql = "UPDATE tbl_appointments SET appointment_status= '1' WHERE appointment_no='$appointmentNo'";

    $db->query($sql);
    header ("Location:viewcustomer.php?status=deactivate");
}
?>