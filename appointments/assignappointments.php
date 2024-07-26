<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">View Appointments</h4>
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
                                    $sql2 = "SELECT * FROM  tbl_services WHERE service_id='$servicename'";
                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc()
                                        ?>
                                    <td><?= $row2['service_name'] ?> </td>
                                    <?php
                                    $db = dbConn();
                                    $customername = $row['customer_id'];
                                    $sql2 = "SELECT * FROM  tbl_customers WHERE customer_id='$customername'";
                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc()
                                        ?>
                                    <td><?= $row2['customer_firstname'] ?>         <?= $row2['customer_lastname'] ?></td>
                                    <td><?= $row2['customer_email'] ?></td>
                                    <td><?= $row['booking_date'] ?></td>
                                    <?php
                                    $db = dbConn();
                                    $timeslotname = $row['time_slot_id'];
                                    $sql3 = "SELECT * FROM  tbl_time_slots WHERE time_slot_id='$timeslotname'";
                                    $result3 = $db->query($sql3);
                                    $row3 = $result3->fetch_assoc()
                                        ?>
                                    <td><?= $row3['time_slot_name'] ?></td>
                                    <td><?= $row3['time_slot_start_time'] ?></td>
                                    <td><?= $row3['time_slot_end_time'] ?></td>
                                    <td>
                                        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                            <?php
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
                                            <input type="text" name="appointment_id" value="<?= $row['appointment_no'] ?>">

                                            <button type="submit" name="action" value="update"
                                                class="btn btn-gradient-primary me-2">Appoint Barber</button>

                                        </form>
                                    </td>
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