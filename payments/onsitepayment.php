<?php include '../menu.php'; ?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointmentNo = $_SESSION["selectedappno"];
    $paymentSlip = $_FILES['payment_slip'];

    if ($_FILES['payment_slip']['name'] != "") {
        $paymentSlip = $_FILES['payment_slip'];
        $filename = $paymentSlip['name'];
        $filetmpname = $paymentSlip['tmp_name'];
        $filesize = $paymentSlip['size'];
        $fileerror = $paymentSlip['error'];
        //take file extension
        $file_ext = explode(".", $filename);
        $file_ext = strtolower(end($file_ext));
        //select allowed file type
        $allowed = array("jpg", "jpeg", "png", "gif");
        //check wether the file type is allowed
        if (in_array($file_ext, $allowed)) {
            if ($fileerror === 0) {
                //file size gives in bytes
                if ($filesize <= 40000000) {
                    //giving appropriate file name. Can be duplicate have to validate using function
                    $new_slip = uniqid('', true) . $app_no . '.' . $file_ext;
                    //directing file destination
                    $file_path = "../assets/images/payments/" . $new_slip;
                    //moving binary data into given destination
                    if (move_uploaded_file($filetmpname, $file_path)) {
                        "The file is uploaded successfully";
                    } else {
                        $message['file_error'] = "File is not uploaded";
                    }
                } else {
                    $message['file_error'] = "File size is invalid";
                }
            } else {
                $message['file_error'] = "File has an error";
            }
        } else {
            $message['file_error'] = "Invalid File type";
        }
    }
    if (empty($message)) {
        $db = dbConn();
        $AddDate = date('Y-m-d');
        $appointment_status = 4;    
        echo $sql = "INSERT INTO tbl_payments(customer_id, appointment_id, payment_slip_file, date) 
                       VALUES ('$customer_name','$app_no','$new_slip','$AddDate')";
        $db->query($sql);

        echo $sql1 = "UPDATE tbl_appointments SET appointment_status= '$appointment_status' WHERE appointment_id= '$app_no'";
        $db->query($sql1);

        // echo "<script>
        //         Swal.fire({
        //             title: 'You Have Successfully Made a Booking!',
        //             text: 'Thank you for choosing us. We'll meet you soon !.',
        //             icon: 'success',
        //             confirmButtonText: 'OK'
        //         }).then(() => {
        //             window.location.href = 'http://localhost/SMS/web/index.php'; // Redirect to Home page
        //         });
        // </script>";
    }
}
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Onsite Customer Handeling</h4>
<div class="container" data-aos="fade-up">

            <div class="row justify-content-center">

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM  tbl_appointments WHERE appointment_status='3' ";
                    $result = $db->query($sql);
                    ?>
                        <label for="exampleInputName1">Select an Appointment No</label>
                        <select type="text" id="exampleInputName1" name="app_no">
                            <option value="">--</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?= $row['appointment_id'] ?>"><?= $row['appointment_no'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM  tbl_appointments WHERE appointment_status='3' ";
                        $result = $db->query($sql);
                        ?>
                        <label for="exampleInputName1">Select Customer Name</label>
                        <select type="text" id="exampleInputName1" name="customer_name">
                            <option value="">--</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?= $row['customer_id'] ?>"><?= $row['customer_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['service_name'] ?></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="exampleInputName1">Upload the Bank Transfer Slip from here</label>
                        <input type="file" id="exampleInputName1" name="payment_slip" value="<?= @$payment_slip ?>">
                        <span class="text-danger"><?= @$message['payment_slip'] ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Confirm</button>
                </div>
                </form>
            </div>