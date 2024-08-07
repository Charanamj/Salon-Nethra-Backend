<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Assign Staff Member to Appointment</h4>
                    <table class="table table-striped">
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
                            <th> Cat Name </th>
                            <th> S Name </th>
                            <th> Cus Name </th>
                            <th> Cus Email </th>
                            <th> Booked Date </th>
                            <th> Time Slot Name </th>
                            <th> Str Time </th>
                            <th> End Time </th>
                            <th> Select Barber </th>
                            <th> Change Barber </th>
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
                                    $servicecategoryname = $row['service_category'];
                                    $sql1 = "SELECT * FROM  tbl_services_category WHERE service_category_id='$servicecategoryname'";
                                    $result1 = $db->query($sql1);
                                    $row1 = $result1->fetch_assoc()
                                        ?>
                                    <td><?= $row1['service_category_name'] ?> </td>
                                    
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
                                    <td><?= $row2['customer_email'] ?></td>
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
                                        @$barber = $row['barber_id'];
                                        if( @$barber != 0){
                                            $db = dbConn();
                                            $sql5 = "SELECT * FROM  tbl_staff WHERE staff_id='$barber'";
                                            $result5 = $db->query($sql5);
                                            $row5 = $result5->fetch_assoc();
                                            echo $row5['staff_firstname'];
                                        }else{
                                            $db = dbConn();
                                            $sql4 = "SELECT * FROM  tbl_staff WHERE staff_designation='4' OR staff_designation='5' ";
                                            $result4 = $db->query($sql4);
                                            ?>
                                            <select type="text" class="form-control" id="exampleInputName1"
                                                name="staff_designation" value="<?= @$staff_designation ?>">
                                                <option value="">- -</option>
                                                <?php
                                                while ($row4 = $result4->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?= $row4['staff_id'] ?>"
                                                        <?= @$staff_designation == $row4['staff_id'] ? 'selected' : '' ?>>
                                                        <?= $row4['staff_firstname'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="text-danger"><?= @$messages['staff_designation'] ?></span>
                                            <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">

                                            <button type="submit" name="action" value="update"
                                                class="btn btn-gradient-primary me-2">Appoint Barber</button>
                                                <?php
                                        }  
                                        ?>                                       
                                
                                    </td>
                                    <td>
                                    <?php
                                        @$barber = $row['barber_id'];
                                        if( @$barber != 0){
                                            $db = dbConn();
                                            $sql4 = "SELECT * FROM  tbl_staff WHERE staff_designation='4' OR staff_designation='5' ";
                                            $result4 = $db->query($sql4);
                                            ?>
                                            <select type="text" class="form-control" id="exampleInputName1"
                                                name="staff_designation" value="<?= @$staff_designation ?>">
                                                <option value="">- -</option>
                                                <?php
                                                while ($row4 = $result4->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?= $row4['staff_id'] ?>"
                                                        <?= @$staff_designation == $row4['staff_id'] ? 'selected' : '' ?>>
                                                        <?= $row4['staff_firstname'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="text-danger"><?= @$messages['staff_designation'] ?></span>
                                            <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">

                                            <button type="submit" name="action" value="update"
                                                class="btn btn-gradient-primary me-2">Change Barber</button>
                                                <?php
                                        }  
                                        ?>
                                    </td>
                                </form>
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