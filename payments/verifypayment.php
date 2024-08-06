<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Onsite Customer Handeling</h4>
                    <table class="table table-striped">
                    <?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    $db = dbConn();
    $sql = "UPDATE tbl_appointments SET appointment_status= '$appointment_status' WHERE appointment_id='$appointment_id'";

    $db->query($sql);
    header ("Location:changeappointments.php?status=activate");
}
?>
                        <?php
                        extract($_POST);
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            extract($_POST);
                            $staff_designation = dataClean($staff_designation);

                            $messages = array();

                            if (!empty($staff_designation)) {
                                $db = dbConn();
                                echo $sql = "UPDATE tbl_appointments SET barber_id='$staff_designation' WHERE appointment_id= '$appointment_id' ";
                                $result = $db->query($sql);

                                $sqlInsert = "INSERT INTO tbl_barber_appointments (appointment_id, 
                                barber_id, time_slot_id, customer_id, service_id, appoint_date) VALUES ('$appointment_id','$staff_designation','$timeslot',
                                '$cid','$sid','$booking_date')";
                                $resultInsert = $db->query($sqlInsert);
                            }
                        }
                        ?>
                        <tr>
                            <th> App No </th>                   
                            <th> S Name </th>
                            <th> Cus Name </th>
                            <th> Booked Date </th>
                            <th> Time Slot Name </th>
                            <th> Str Time </th>
                            <th> End Time </th>
                            <th> Status </th>
                            <th> Change Status </th>
                        </tr>
                        <?php
                        extract($_POST);
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'filter') {
                            extract($_POST);
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_appointments WHERE appointment_status = '$filter_status' ";
                            $result = $db->query($sql);
                        } else {
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_appointments";
                            $result = $db->query($sql);
                        }
                        ?>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <td><?= $row['appointment_no'] ?> </td>  
                                    <?php
                                    $db = dbConn();
                                    $servicename = $row['service_name'];
                                    ?>
                                    <?php
                                    $sql2 = "SELECT * FROM  tbl_services WHERE service_id='$servicename'";
                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc()
                                    ?>
                                    <input type="hidden" name="sid" value="<?= $row2['service_id'] ?>">
                                    <td><?= $row2['service_name'] ?> </td>
                                    <?php
                                    $db = dbConn();
                                    $customername = $row['customer_id'];
                                    ?>
                                    <input type="hidden" name="cid" value="<?= $customername ?>">
                                    <?php
                                    $sql2 = "SELECT * FROM  tbl_customers WHERE customer_id='$customername'";
                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc()
                                    ?>
                                    <td><?= $row2['customer_firstname'] ?>         <?= $row2['customer_lastname'] ?></td>
                                    <input type="hidden" name="booking_date" value="<?= $row['booking_date'] ?>">
                                    <td><?= $row['booking_date'] ?></td>
                                    
                                    <?php
                                    $db = dbConn();
                                    $timeslotname = $row['time_slot_id'];
                                    ?>
                                    <input type="hidden" name="timeslot" value="<?= $timeslotname ?>">
                                    <?php
                                    $sql3 = "SELECT * FROM  tbl_time_slots WHERE time_slot_id='$timeslotname'";
                                    $result3 = $db->query($sql3);
                                    $row3 = $result3->fetch_assoc()
                                    ?>
                                    <td><?= $row3['time_slot_name'] ?></td>
                                    <td><?= $row3['time_slot_start_time'] ?></td>
                                    <td><?= $row3['time_slot_end_time'] ?></td>
                                    <td>
                                        <?php
                                        $appstatus = $row['appointment_status'];
                                        if ($appstatus == "1") {
                                            echo "Pending";
                                        } else if ($appstatus == "2") {
                                            echo "Advance Payment";
                                        } else if ($appstatus == "3") {
                                            echo "Processing";
                                        } else if ($appstatus == "4") {
                                            echo "Completed Payment";
                                        } else if ($appstatus == "5") {
                                            echo "Cancelled/Customer";
                                        } else if ($appstatus == "6") {
                                            echo "Cancelled/Salon";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                            <select type="text" class="form-control" id="exampleInputName1"
                                                name="appointment_status" value="<?= @$appointment_status ?>">
                                                <option value="">- -</option>
                                                <option value="3" <?php
                                                if (@$appointment_status == "3") {
                                                    echo "selected";
                                                }
                                                ?>>Processing</option>
                                                <option value="4" <?php
                                                if (@$appointment_status == "4") {
                                                    echo "selected";
                                                }
                                                ?>>Completed Payment</option>
                                                <option value="5" <?php
                                                if (@$appointment_status == "5") {
                                                    echo "selected";
                                                }
                                                ?>>Cancelled/Customer</option>
                                                <option value="6" <?php
                                                if (@$appointment_status == "6") {
                                                    echo "selected";
                                                }
                                                ?>>Cancelled/Salon</option>
                                            </select>
                                            <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">
                                            <button type="submit" name="action" value="update"
                                                class="btn btn-gradient-primary me-2">Change Status</button>
                                    </td>
                                </form>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>