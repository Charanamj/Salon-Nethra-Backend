<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">My Appointments</h4>
                    <table class="table table-striped">
                        <?php
                        extract($_POST);
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            extract($_POST);
                            $staff_designation = dataClean($staff_designation);

                            $messages = array();

                            if (!empty($staff_designation)) {
                                $db = dbConn();
                                $sql = "UPDATE tbl_appointments SET barber_id='$staff_designation' WHERE appointment_no= '$appointment_id' ";
                                $result = $db->query($sql);

                                $sqlInsert = "INSERT INTO tbl_barber_appointments (appointment_id, 
                                barber_id, time_slot_id, customer_id, service_id, appoint_date) VALUES ('$appointment_id','$staff_designation','$timeslot',
                                '$cid','$sid','$booking_date')";
                                $resultInsert = $db->query($sqlInsert);
                            }
                        }
                        ?>
                        <tr>
                            <th> Appoint No </th>
                            <th> Bar. Name </th>
                            <th> Time Slot Name </th>
                            <th> Cus. Name </th>
                            <th> Service Name </th>
                            <th> Service Date </th>
                        </tr>
                        <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_barber_appointments";
                            $result = $db->query($sql);
                        ?>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <?php
                                    $db = dbConn();
                                    $AppNo = $row['appointment_id'];
                                    $sql1 = "SELECT * FROM  tbl_appointments WHERE appointment_id='$AppNo'";
                                    $result1 = $db->query($sql1);
                                    $row1 = $result1->fetch_assoc()
                                    ?>
                                    <td><?= $row1['appointment_no'] ?> </td>
                                    
                                    <?php
                                    $db = dbConn();
                                    $sql2 = "SELECT * FROM  tbl_staff WHERE staff_designation='4' OR staff_designation='5' ";
                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc()
                                    ?>
                                    <td><?= $row2['staff_username'] ?> </td>

                                    <?php
                                    $db = dbConn();
                                    $timeslotname = $row['time_slot_id'];
                                    $sql3 = "SELECT * FROM  tbl_time_slots WHERE time_slot_id='$timeslotname'";
                                    $result3 = $db->query($sql3);
                                    $row3 = $result3->fetch_assoc()
                                    ?>
                                    <td><?= $row3['time_slot_name'] ?> </td>
                                    
                                    <?php
                                    $db = dbConn();
                                    $customertname = $row['customer_id'];
                                    $sql4 = "SELECT * FROM  tbl_customers WHERE customer_id='$customertname'";
                                    $result4 = $db->query($sql4);
                                    $row4 = $result4->fetch_assoc()
                                    ?>
                                    <td><?= $row4['customer_firstname'] ?> <?= $row4['customer_lastname'] ?></td>

                                    <?php
                                    $db = dbConn();
                                    $servicename = $row['service_id'];
                                    $sql5 = "SELECT * FROM  tbl_services WHERE service_id='$servicename'";
                                    $result5 = $db->query($sql5);
                                    $row5 = $result5->fetch_assoc()
                                    ?>
                                    <td><?= $row5['service_name'] ?></td>

                                    <?php
                                    $db = dbConn();
                                    $servicedate = $row['appointment_id'];
                                    $sql6 = "SELECT * FROM  tbl_appointments WHERE appointment_id='$servicedate'";
                                    $result6 = $db->query($sql6);
                                    $row6 = $result6->fetch_assoc()
                                    ?>
                                    <td><?= $row6['booking_date'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <!-- <tbody>
                           
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>