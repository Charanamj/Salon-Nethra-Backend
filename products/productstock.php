<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Salon Products Serial Details Table</h4>
                    <table class="table table-striped">
                        <div>
                        <?php
                            $where = null;
                            extract($_POST);
                            if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'filter') {
                                extract($_POST);
                                if (!empty($productname)) {
                                    $where .= " product_id='$productname' AND";
                                }
                                if (!empty($productcategoryname)) {
                                    $where .= " product_category_id='$productcategoryname' AND";
                                }
                                if (!empty($batchname)) {
                                    $where .= " batch_id='$batchname' AND";
                                }
                                if (!empty($from) && empty($to)) {
                                    $where .= " product_add_date LIKE '%$from%' AND";
                                }
                                if (empty($from) && !empty($to)) {
                                    $where .= " product_add_date LIKE '%$to%' AND";
                                }
                                if (!empty($from) && !empty($to)) {
                                    $where .= " product_add_date  BETWEEN LIKE '%$from%' AND LIKE '%$to%' AND";
                                }
                                if (!empty($where)) {
                                    $where = substr($where, 0, -3);
                                    $where = " WHERE $where";
                                }
                            }
                            ?>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="row g-3">
                                    <div class="col-sm">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM tbl_product_names";
                                        $result = $db->query($sql);
                                        ?>
                                        <select name="productname" class="form-control">
                                            <option value="">--Product Name--</option>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['product_name_id']; ?>" <?php echo @$productname == $row['product_name_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row['product_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <?php
                                        $sql = "SELECT * FROM tbl_products_category";
                                        $result = $db->query($sql);
                                        ?>
                                        <select name="productcategoryname" class="form-control">
                                            <option value="">--Product Category Name--</option>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['product_category_id']; ?>" <?php echo @$productcategoryname == $row['product_category_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row['product_category_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <?php
                                        $sql = "SELECT * FROM tbl_batches";
                                        $result = $db->query($sql);
                                        ?>
                                        <select name="batchname" class="form-control">
                                            <option value="">--Batch Name--</option>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['batch_id']; ?>" <?php echo @$batchname == $row['batch_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($row['batch_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" class="form-control" name="from"  placeholder="Enter From Date" value="<?php echo htmlspecialchars(@$from); ?>">
                                    </div>
                                    <div class="col-sm">
                                        <input type="date" class="form-control" name="to"  placeholder="Enter To Date" value="<?php echo htmlspecialchars(@$to); ?>">
                                    </div>
                                    <div class="col-sm">
                                        <button type="submit" class="btn btn-warning" name="action" value="filter">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <thead>
                            <tr>
                                <th> Product Name </th>
                                <th> Product Category Name </th>
                                <th> Product Batch Name </th>
                                <th> Product Serial Number </th>                                
                                <th> Product Price </th>                              
                                <th> Add Date </th>
                                <th> Expire Date </th>
                                <th> Added by </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            if ($where != null){
                            $sql = "SELECT * FROM tbl_products_serial_number $where";
                            $result = $db->query($sql);
                            }else{
                                $sql = "SELECT * FROM tbl_products_serial_number";
                                $result = $db->query($sql);
                            }
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <?php
                                        $db = dbConn(); 
                                        $productid= $row['product_id'];  '<br>';
                                        $sql10 = "SELECT * FROM  tbl_products WHERE product_id='$productid'";
                                         '<br>';
                                        $result10 = $db->query($sql10);
                                        $row10 = $result10->fetch_assoc();
                                        $pnameid = $row10["product_name_id"];  '<br>';
                                        $sql8 ="SELECT * FROM  tbl_product_names WHERE product_name_id='$pnameid'";
                                         '<br>';
                                        $result8 = $db->query($sql8);
                                        $row8 = $result8->fetch_assoc();
                                        ?>
                                        <td><?= $row8['product_name'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productcategoryname = $row['product_category_id'];
                                        $sql2 = "SELECT * FROM  tbl_products_category WHERE product_category_id='$productcategoryname'";
                                        $result2 = $db->query($sql2);
                                        $row2 = $result2->fetch_assoc()
                                        ?>
                                        <td><?= $row2['product_category_name'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $batchname = $row['batch_id'];
                                        $sql3 = "SELECT * FROM  tbl_batches WHERE batch_id='$batchname'";
                                        $result3 = $db->query($sql3);
                                        $row3 = $result3->fetch_assoc()
                                        ?>
                                        <td><?= $row3['batch_name'] ?> </td>
                                        <td><?= $row['product_serialnumber'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productprice = $row['product_id'];
                                        $sql4 = "SELECT * FROM  tbl_products WHERE product_id='$productprice'";
                                        $result4 = $db->query($sql4);
                                        $row4 = $result4->fetch_assoc()
                                        ?>
                                        <td><?= $row4['product_price'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productadddate = $row['product_id'];
                                        $sql5 = "SELECT * FROM  tbl_products WHERE product_id='$productadddate'";
                                        $result5 = $db->query($sql5);
                                        $row5 = $result5->fetch_assoc()
                                        ?>
                                        <td><?= $row4['productadd_date'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productexpiredate = $row['product_id'];
                                        $sql6 = "SELECT * FROM  tbl_products WHERE product_id='$productexpiredate'";
                                        $result6 = $db->query($sql6);
                                        $row6 = $result6->fetch_assoc()
                                        ?>
                                        <td><?= $row6['productexpire_date'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productadduser = $_SESSION['LogId'];
                                        $sql7 = "SELECT * FROM  tbl_staff WHERE staff_id='$productadduser'";
                                        $result7 = $db->query($sql7);
                                        $row7 = $result7->fetch_assoc()
                                        ?>
                                        <td><?= $row7['staff_firstname'] . ' ' . $row7['staff_lastname'] ?> </td>
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