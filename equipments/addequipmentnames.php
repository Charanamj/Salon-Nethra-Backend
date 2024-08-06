<?php include '../menu.php'; ?>


<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'addequipmentname') {
  extract($_POST);
  $equipment_name = dataClean($equipment_name);
  $equipment_category = dataClean($equipment_category);

  $messages = array();

  if (empty($equipment_name)) {
    $messages['equipment_name'] = "The equipment name should not be empty..!";
  }
  if (!empty($equipment_name)) {
    $db = dbConn();
    $lower = strtolower($equipment_name);
    $sql = "SELECT * FROM  tbl_equipment_names WHERE equipment_name='$equipment_name'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $messages['equipment_name'] = "This equipment name is already in the database";
    }
}
  if (empty($equipment_category)) {
    $messages['equipment_category'] = "The equipment category should be select..!";
  }

if (empty($messages)) {
    $db = dbConn();
    // $AddUser = $_SESSION['UserId'];
    $AddDate = date('Y-m-d');
    $status = 1;
    $sql = "INSERT INTO tbl_equipment_names (equipment_category_id, equipment_name) VALUES ('$equipment_category','$equipment_name')";

    $db->query($sql);
    echo "<script>
        Swal.fire({
            title: 'Added!',
            text: 'Added Successfully !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/system/equipments/addequipmentname.php'; // Redirect to success page
        });
</script>";
}
}

?>
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
    }

    .card-description {
        margin-bottom: 20px;
        font-size: 16px;
        color: #666;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .text-danger {
        color: #dc3545;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #2196F3, #04befe);
        color: white;
        border: none;
    }

    .btn-light {
        background-color: #f1f1f1;
        color: #333;
        border: 1px solid #ccc;
    }
</style>

<div class="col-1 grid-margin stretch-card"></div>
<div class="col-8 grid-margin stretch-card" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Equipments Names used at the Salon</h4>
            <p class="card-description"> Add equipment Name </p>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                    <?php
                    $db = dbConn();
                    $sql2 = "SELECT * FROM  tbl_equipment_category";
                    $result2 = $db->query($sql2);
                    ?>
                    <label for="exampleInputName1">Select Equipment Category</label>
                    <select type="text" class="form-control" id="exampleInputName1" name="equipment_category">
                        <option value="">--</option>
                        <?php
                        while ($row = $result2->fetch_assoc()) {
                            ?>
                            <option value="<?= $row['equipment_category_id'] ?>"
                                <?= @$tbl_products_category == $row['equipment_category_id'] ? 'selected' : '' ?>>
                                <?= $row['equipment_category_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?= @$messages['equipment_category'] ?></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Enter Equipment Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="equipment_name"
                        value="<?= @$equipment_name ?>" placeholder="Enter the equipment name">
                    <span class="text-danger"><?= @$messages['equipment_name'] ?></span>
                </div>
                <button type="submit" name="action" class="btn btn-gradient-primary me-2" value="addequipmentname">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>
<div class="col-1 grid-margin stretch-card"></div>
<?php include '../footer.php'; ?>