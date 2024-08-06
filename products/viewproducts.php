<?php include '../menu.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Salon Products Stock Details Table</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Product Category Name </th>
                                <th> Product Name </th>
                                <th> Product Iamge </th>
                                <th> Product Price </th>
                                <th> Product Quantity </th>
                                <th> Add User Name </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_products";
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
                                        $productcategoryname = $row['product_category_id'];
                                        $sql1 = "SELECT * FROM  tbl_products_category WHERE product_category_id='$productcategoryname'";
                                        $result1 = $db->query($sql1);
                                        $row1 = $result1->fetch_assoc()
                                        ?>
                                        <td><?= $row1['product_category_name'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productname = $row['product_name_id'];
                                        $sql2 = "SELECT * FROM  tbl_product_names WHERE product_name_id='$productname'";
                                        $result2 = $db->query($sql2);
                                        $row2 = $result2->fetch_assoc()
                                        ?>
                                        <td><?= $row2['product_name'] ?> </td>
                                        <td class="py-1">
                                            <img src="../assets/images/products/<?= $row['product_image'] ?>" alt="image" />
                                        </td>
                                        <td><?= $row['product_price'] ?> </td>
                                        <td><?= $row['product_quantity'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $productadduser = $_SESSION['LogId'];
                                        $sql4 = "SELECT * FROM  tbl_staff WHERE staff_id='$productadduser'";
                                        $result4 = $db->query($sql4);
                                        $row4 = $result4->fetch_assoc()
                                        ?>
                                        <td><?= $row4['staff_firstname'] . ' ' . $row4['staff_lastname'] ?> </td>
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