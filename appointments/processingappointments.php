<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">View Appointments</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Appointment No </th>
                                <th> Service Category Name </th>
                                <th> Service Name </th>
                                <th> Customer Name </th>
                                <th> Customer Telephone Number </th>
                                <th> Customer Email </th>
                                <th> Booked Date </th>
                                <th> Time Slot Name </th>
                                <th> Start Time </th>
                                <th> End Time </th>
                                <th> Add Date </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_appointments WHERE appointment_status='1'";
                            $result = $db->query($sql);
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
                                        <td><?= $row3['time_slot_start_time'] ?></td>
                                        <td><?= $row3['time_slot_end_time'] ?></td>
                                        <td><?= $row['add_date'] ?></td>
                                     <td>
                                        <?php
                                        $appstatus= $row['appointment_status'];
                                        if($appstatus == "1"){
                                           echo "Processing";
                                        }else if($appstatus == "2"){
                                            echo "Completed";
                                        }else if($appstatus == "3"){
                                            echo "Cancelled";  
                                            }
                                        ?>
                                    </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>