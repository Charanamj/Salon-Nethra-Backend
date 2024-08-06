<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<?php include '../menu.php'; ?>

<?php
extract($_POST);
//name action value add designation wena ekakin awama witharai meka wenne
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'addequipmentcategory') {
  extract($_POST);
  $equipment_category_name = dataClean($equipment_category_name);

  $messages = array();

if (empty($equipment_category_name)) {
    $messages['equipment_category_name'] = "The equipment name should not be empty..!";
}

if (empty($messages)) {
    $db = dbConn();
    // $AddUser = $_SESSION['UserId'];
    $AddDate = date('Y-m-d');
    $status = 1;
    $sql = "INSERT INTO tbl_equipment_category (equipment_category_name) VALUES ('$equipment_category_name')";

    $db->query($sql);
    echo "<script>
        Swal.fire({
            title: 'Added!',
            text: 'Added Successfully !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/system/equipments/addequipmentcategory.php'; // Redirect to success page
        });
</script>";
}
}

?>
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Adding Salon Equipments Categories</h4>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
          <label for="exampleInputName1">Equipment Category Name</label>
          <input type="text" class="form-control" id="exampleInputName1" name="equipment_category_name"
            value="<?= @$equipment_category_name ?>" placeholder="Enter the equipment category Name">
          <span class="text-danger"><?= @$messages['equipment_category_name'] ?></span>
        </div>
        <button type="submit" name="action" value="addequipmentcategory" class="btn btn-gradient-primary me-2">Submit</button>
        <!-- <button class="btn btn-light">Cancel</button> -->
    </form>
</div>
</div>
</div>
<?php include '../footer.php'; ?>


        