<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<?php include '../menu.php'; ?>

<?php
extract($_POST);
//name action value add designation wena ekakin awama witharai meka wenne
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'addprices') {
  extract($_POST);
  $staffpay = dataClean($staffpay);
  $utilitypay = dataClean($utilitypay);
  $profitpay = dataClean($profitpay);

  $messages = array();

if (empty($staffpay)) {
    $messages['staffpay'] = "The field should not be empty..!";
}
if (empty($utilitypay)) {
    $messages['utilitypay'] = "The field should not be empty..!";
}
if (empty($profitpay)) {
    $messages['profitpay'] = "The field should not be empty..!";
}

if (empty($messages)) {
    $db = dbConn();
    // $AddUser = $_SESSION['UserId'];
    $AddDate = date('Y-m-d');
    $status = 1;
    $sql = "INSERT INTO tbl_prices (staff_pay,utility_pay,profit_pay) VALUES ('$staffpay','$utilitypay','$profitpay')";

    $db->query($sql);
    echo "<script>
        Swal.fire({
            title: 'Added!',
            text: 'Added Successfully !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/system/payments/addprices.php'; // Redirect to success page
        });
</script>";
}
}

?>
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Adding Prices for the Services at the Salon</h4>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
          <label for="exampleInputName1">Price Rate for the Staff</label>
          <input type="text" class="form-control" id="exampleInputName1" name="staffpay"
            value="<?= @$staffpay ?>" placeholder="Enter a value here">
          <span class="text-danger"><?= @$messages['staffpay'] ?></span>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Price Rate for Utility</label>
          <input type="text" class="form-control" id="exampleInputName1" name="utilitypay"
            value="<?= @$utilitypay ?>" placeholder="Enter a value here">
          <span class="text-danger"><?= @$messages['utilitypay'] ?></span>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Price Rate for Profit</label>
          <input type="text" class="form-control" id="exampleInputName1" name="profitpay"
            value="<?= @$profitpay ?>" placeholder="Enter a value here">
          <span class="text-danger"><?= @$messages['profitpay'] ?></span>
        </div>
        <button type="submit" name="action" value="addprices" class="btn btn-gradient-primary me-2">Submit</button>
        <!-- <button class="btn btn-light">Cancel</button> -->
    </form>
</div>
</div>
</div>
<?php include '../footer.php'; ?>


        