<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<?php include '../menu.php'; ?>

<?php
extract($_POST);
//name action value add designation wena ekakin awama witharai meka wenne
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'addproductcategory') {
  extract($_POST);
  $product_category_name = dataClean($product_category_name);

  $messages = array();

if (empty($product_category_name)) {
    $messages['product_category_name'] = "The category name should not be empty..!";
}

if (empty($messages)) {
    $db = dbConn();
    // $AddUser = $_SESSION['UserId'];
    $AddDate = date('Y-m-d');
    $status = 1;
    $sql = "INSERT INTO `tbl_products_category` (product_category_name) VALUES ('$product_category_name')";

    $db->query($sql);
    echo "<script>
        Swal.fire({
            title: 'Added!',
            text: 'Added Successfully !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/system/products/addproductcategory.php'; // Redirect to success page
        });
</script>";
}
}

?>
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Adding Salon Products Categories</h4>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
          <label for="exampleInputName1">Product Category Name</label>
          <input type="text" class="form-control" id="exampleInputName1" name="product_category_name"
            value="<?= @$product_category_name ?>" placeholder="Enter the product category Name">
          <span class="text-danger"><?= @$messages['product_category_name'] ?></span>
        </div>
        <button type="submit" name="action" value="addproductcategory" class="btn btn-gradient-primary me-2">Submit</button>
        <!-- <button class="btn btn-light">Cancel</button> -->
    </form>
    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Product Category ID </th>
                                <th> Product Category Name </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_products_category";
                            $result = $db->query($sql);
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['product_category_id'] ?> </td>
                                        <td><?= $row['product_category_name'] ?> </td>
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
<?php include '../footer.php'; ?>


        