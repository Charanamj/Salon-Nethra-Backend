<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">View Appointments</h4>
                    <table class="table table-striped">
                        <div>
                            <?php
                            $where = null;
                            extract($_POST);
                            if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'filter') {
                                extract($_POST);
                                if (!empty($AppNo)) {
                                    $where .= " appointment_no='$AppNo' AND";
                                }
                                if (!empty($servicecategory)) {
                                    $where .= " service_category='$servicecategory' AND";
                                }
                                if (!empty($servicename)) {
                                    $where .= " service_name='$servicename' AND";
                                }
                                if (!empty($CusName)) {
                                    $where .= " customer_name LIKE '%$CusName%' AND";
                                }
                                if (!empty($from) && empty($to)) {
                                    $where .= " booking_date='$from' AND";
                                }
                                if (empty($from) && !empty($to)) {
                                    $where .= " booking_date='$to' AND";
                                }
                                if (!empty($from) && !empty($to)) {
                                    $where .= " booking_date  BETWEEN '$from' AND '$to' AND";
                                }
                                if (!empty($membername)) {
                                    $where .= " barber_id='$membername' AND";
                                }
                                if (!empty($where)) {
                                    $where = substr($where, 0, -3);
                                    $where = " WHERE $where";
                                }
                            }
                            ?>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <input type="text" name="AppNo" value="<?php echo htmlspecialchars(@$AppNo); ?>" class="form-control" placeholder="Enter Appointment No.">
                                    </div>
                                    <div class="col-sm">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM tbl_services_category";
                                        $result = $db->query($sql);
                                        ?>
                                        <select name="servicecategory" class="form-control">
                                            <option value="">--Service Category Name--</option>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['service_category_id']; ?>" <?php echo @$servicecategory == $row['service_category_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row['service_category_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <?php
                                        $sql = "SELECT * FROM tbl_services";
                                        $result = $db->query($sql);
                                        ?>
                                        <select name="servicename" class="form-control">
                                            <option value="">--Service Name--</option>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['service_id']; ?>" <?php echo @$servicename == $row['service_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row['service_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="CusName" value="<?php echo htmlspecialchars(@$CusName); ?>" class="form-control" placeholder="Enter Customer Name">
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" class="form-control" name="from"  placeholder="Enter From Date" value="<?php echo htmlspecialchars(@$from); ?>">
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" class="form-control" name="to"  placeholder="Enter To Date" value="<?php echo htmlspecialchars(@$to); ?>">
                                    </div>
                                    <div class="col-sm">
                                        <?php
                                        $hairdresser = '4';
                                        $beautician = '5';
                                        $sql10 = "SELECT * FROM tbl_staff WHERE staff_designation='$hairdresser' OR staff_designation='$beautician'";
                                        $result10 = $db->query($sql10);
                                        ?>
                                        <select name="membername" class="form-control">
                                            <option value="">--Staff Member Name--</option>
                                            <?php while ($row10 = $result10->fetch_assoc()) { ?>
                                                <option value="<?php echo $row10['staff_id']; ?>" <?php echo @$membername == $row10['staff_designation'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row10['staff_firstname']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <button type="submit" class="btn btn-warning" name="action" value="filter">Search</button>
                                    </div>
                                </div>
                            </form>




                        </div>
                        <tr>
                            <th> Appointment No </th>
                            <th> Service Category Name </th>
                            <th> Service Name </th>
                            <th> Customer Name </th>
                            <th> Customer Telephone Number </th>
                            <th> Customer Email </th>
                            <th> Booked Date </th>
                            <th> Time Slot Name </th>
                            <th> Barber Name </th>
                            <th> Start Time </th>
                            <th> End Time </th>
                            <th> Add Date </th>
                            <th> Change Status </th>
                        </tr>
                        <?php
                       
                            extract($_POST);
                            $db = dbConn();
                            if ($where != null){
                                $sql100 = "SELECT * FROM tbl_appointments $where";
                                $result = $db->query($sql100);
                            }else{
                                echo $sql100 = "SELECT * FROM tbl_appointments";
                                $result = $db->query($sql100);
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
                                    <td><?= $row2['customer_mobilenumber'] ?></td>
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
                                    <?php
                                    $db = dbConn();
                                    $barbername = $row['barber_id'];
                                    $sql4 = "SELECT * FROM  tbl_staff WHERE staff_id='$barbername'";
                                    $result4 = $db->query($sql4);
                                    $row4 = $result4->fetch_assoc()
                                    ?>
                                    <td><?= $row4['staff_firstname'] ?></td>
                                    <td><?= $row3['time_slot_start_time'] ?></td>
                                    <td><?= $row3['time_slot_end_time'] ?></td>
                                    <td><?= $row['add_date'] ?></td>
                                    <td>
                                        <form method="post" action="activateappointment.php">
                                            <select type="text" class="form-control" id="exampleInputName1"
                                                    name="appointment_status" value="<?= @$appointment_status ?>">
                                                <option value="">- -</option>
                                                <option value="1" <?php
                            if (@$appointment_status == "1") {
                                echo "selected";
                            }
                                    ?>style="color: green;">Pending</option>
                                                <option value="2" <?php
                                        if (@$appointment_status == "2") {
                                            echo "selected";
                                        }
                                    ?>>Advance Payment</option>
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
                                        </form>
                                    </td>
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