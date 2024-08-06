<?php include '../menu.php'; ?>


<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
    $equipment_category = dataClean($equipment_category);
    $batch_name = dataClean($batch_name);
    $equipment_name = dataClean($equipment_name);
    $equipment_serialnumber = dataClean($equipment_serialnumber);
    $equipment_description = dataClean($equipment_description);
    $equipment_price = dataClean($equipment_price);
    $equipment_image = $_FILES['equipment_image'];
    $equipmentwarrantyexpire_date = dataClean($equipmentwarrantyexpire_date);
    //$equipment_warranty_availability = dataClean($equipment_warranty_availability);

    $messages = array();

    if (empty($equipment_category)) {
        $messages['equipment_category'] = "The equipment category should be select..!";
    }
    if (empty($batch_name)) {
        $messages['batch_name'] = "The product bacth id should be select..!";
    }
    if (empty($equipment_name)) {
        $messages['equipment_name'] = "The equipment name should be select..!";
    }
    if (empty($equipment_serialnumber)) {
        $messages['equipment_serialnumber'] = "The product serial number should not be empty..!";
    }
    if (!empty($equipment_serialnumber)) {

        $serialnumberlength = strlen($equipment_serialnumber);
        if ($serialnumberlength == 10 || $serialnumberlength == 12) {

        } else {
            $message['equipment_serialnumber'] = "The serial number length should 10 or 12!";
        }
    }
    if (empty($equipment_description)) {
        $messages['equipment_description'] = "The equipment description should not be empty..!";
    }
    if (empty($equipment_price)) {
        $messages['equipment_price'] = "The equipment price should not be empty..!";
    }
    if (empty($equipmentwarrantyexpire_date)) {
        $messages['equipmentwarrantyexpire_date'] = "The equipment expire date should be select..!";
    }
    if (empty($equipment_warranty_availability)) {
        $messages['equipment_warranty_availability'] = "The should be select..!";
    }
    if (!empty($equipment_serialnumber)) {
        $db = dbConn();
        $sql = "SELECT * FROM  tbl_equipment_serial_number WHERE equipment_serialnumber='$equipment_serialnumber'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $messages['equipment_serialnumber'] = "This equipment serial number is already in the database";
        }
    }
    if ($_FILES['equipment_image']['name'] != "") {
        $equipment_image = $_FILES['equipment_image'];
        $filename = $equipment_image['name'];
        $filetmpname = $equipment_image['tmp_name'];
        $filesize = $equipment_image['size'];
        $fileerror = $equipment_image['error'];
        //take file extension
        $file_ext = explode(".", $filename);
        $file_ext = strtolower(end($file_ext));
        //select allowed file type
        $allowed = array("jpg", "jpeg", "png", "gif");
        //check wether the file type is allowed
        if (in_array($file_ext, $allowed)) {
            if ($fileerror === 0) {
                //file size gives in bytes
                if ($filesize <= 40000000) {
                    //giving appropriate file name. Can be duplicate have to validate using function
                    $file_name_new = uniqid('', true) . $equipment_image . '.' . $file_ext;
                    //directing file destination
                    $file_path = "../assets/images/products/" . $file_name_new;
                    //moving binary data into given destination
                    if (move_uploaded_file($filetmpname, $file_path)) {
                        "The file is uploaded successfully";
                    } else {
                        $messages['file_error'] = "File is not uploaded";
                    }
                } else {
                    $messages['file_error'] = "File size is invalid";
                }
            } else {
                $messages['file_error'] = "File has an error";
            }
        } else {
            $messages['file_error'] = "Invalid File type";
        }
    }

    if (empty($messages)) {
        $db = dbConn();
        $AddUser = $_SESSION['LogId'];
        $lower = strtolower($equipment_name);
        $AddDate = date('Y-m-d');
        $status = 1;
        //create a new variable name for product quantity and assigned it 1.
        $equipmentquantity = 1;
        //select product name id from the product table.
        $sql = "SELECT * FROM  tbl_equipments WHERE equipment_name_id='$equipment_name'";
        $result = $db->query($sql);
        //if there are records with related to product name, the quantity will update according to that
        //(UPDATE the tbl_products & INSERT serial number for tbl_products_serial_number)
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sqlcheck = "UPDATE tbl_equipments SET equipment_quantity= equipment_quantity + 1 WHERE equipment_name_id='$equipment_name'";
            $db->query($sqlcheck);
            $productid = $row ['product_id'];
            $sql1 = "INSERT INTO tbl_equipment_serial_number (equipment_id,equipment_category_id,batch_id,
            equipment_serialnumber) VALUES ('$equipment_id','$equipment_category','$batch_name','$equipment_serialnumber')";

            $db->query($sql1);

            echo "<script>
            Swal.fire({
                title: 'Added!',
                text: 'Added Successfully !.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'http://localhost/SMS/system/equipments/addequipments.php'; // Redirect to success page
            });
    </script>";
            //if there are no records with related to product name, the new product name & the quantity will update according to that
            //(INSERT into the tbl_products & INSERT the serial number for tbl_products_serial_number)
        } else {
            $sql = "INSERT INTO tbl_equipments (batch_id,equipment_category_id,equipment_name_id,equipment_description,
            equipment_price, equipment_quantity, equipmentadd_user, equipment_image, equipmentadd_date, equipment_warranty_availability, 
            equipmentwarrantyexpire_date) 
            VALUES ('$batch_name','$equipment_category','$equipment_name','$equipment_description',
            '$equipment_price','$equipment_quantity','$AddUser','$file_name_new','$AddDate','$equipment_warranty_availability',
            '$equipmentwarrantyexpire_date')";

            $db->query($sql);
            $product_id = $db->insert_id;
            $sql1 = "INSERT INTO tbl_equipment_serial_number (equipment_id,equipment_category_id,batch_id,
            equipment_serialnumber) VALUES ('$equipment_id','$equipment_category','$batch_name','$equipment_serialnumber')";

            $db->query($sql1);
            echo "<script>
            Swal.fire({
                title: 'Added!',
                text: 'Added Successfully !.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'http://localhost/SMS/system/equipments/addequipments.php'; // Redirect to success page
            });
    </script>";
        }

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

<!-- Your PHP and HTML code here -->

<div class="col-1 grid-margin stretch-card"></div>
<div class="col-8 grid-margin stretch-card" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Equipments of the Salon</h4>
            <p class="card-description"> Add Salon Equipments </p>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
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
                    <?php
                    $db = dbConn();
                    $sql3 = "SELECT * FROM  tbl_batches";
                    $result3 = $db->query($sql3);
                    ?>
                    <label for="exampleInputName1">Select Batch Category</label>
                    <select type="text" class="form-control" id="exampleInputName1" name="batch_name">
                        <option value="">--</option>
                        <?php
                        while ($row = $result3->fetch_assoc()) {
                            ?>
                            <option value="<?= $row['batch_id'] ?>" <?= @$tbl_batches == $row['batch_id'] ? 'selected' : '' ?>>
                                <?= $row['batch_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?= @$messages['batch_name'] ?></span>
                </div>
                <div class="form-group">
                    <?php
                    $db = dbConn();
                    $sql4 = "SELECT * FROM  tbl_equipment_names";
                    $result4 = $db->query($sql4);
                    ?>
                    <label for="exampleInputName1">Select Equipment Name</label>
                    <select type="text" class="form-control" id="exampleInputName1" name="equipment_name">
                        <option value="">--</option>
                        <?php
                        while ($row = $result4->fetch_assoc()) {
                            ?>
                            <option value="<?= $row['equipment_name_id'] ?>" <?= @$tbl_product_names == $row['equipment_name_id'] ? 'selected' : '' ?>>
                                <?= $row['equipment_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?= @$messages['equipment_name'] ?></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Equipment Serial Number</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="equipment_serialnumber"
                        value="<?= @$equipment_serialnumber ?>" placeholder="Enter the equipment serial number">
                    <span class="text-danger"><?= @$messages['equipment_serialnumber'] ?></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Equipment Description</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="equipment_description"
                        value="<?= @$equipment_description ?>" placeholder="Enter the equipment description">
                    <span class="text-danger"><?= @$messages['equipment_description'] ?></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Equipment Price</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="equipment_price"
                        value="<?= @$equipment_price ?>" placeholder="Enter the equipment price">
                    <span class="text-danger"><?= @$messages['equipment_price'] ?></span>
                </div>
                <div class="form-group mt-3">
                <div class="form-check">
                    <label>Is warranty Availabe for this equipment ?</label>
                    <input class="form-check-input border border-1 border-dark" type="radio"
                                name="equipment_warranty_availability" <?php if (isset($equipment_warranty_availability) && $equipment_warranty_availability == "yes")
                                    echo "checked"; ?> id="yes" value="yes">
                    <label class="form-check-label" for="yes">
                        Yes
                    </label>
                </div>        
                <div class="form-check">
                    <input class="form-check-input border border-1 border-dark" type="radio"
                                name="equipment_warranty_availability" <?php if (isset($equipment_warranty_availability) && $equipment_warranty_availability == "no")
                                    echo "checked"; ?> id="no" value="no">
                    <label class="form-check-label" for="no">
                        No
                    </label>
                </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Equipment Expire Day</label>
                    <input type="date" class="form-control" id="exampleInputName1" name="equipmentwarrantyexpire_date"
                        value="<?= @$equipmentwarrantyexpire_date ?>" placeholder="Select the equipment expire date">
                    <span class="text-danger"><?= @$messages['equipmentwarrantyexpire_date'] ?></span>
                </div>
                <div class="form-group">
                    <label>Equipment Image</label><br>
                    <input type="file" name="equipment_image">
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>
<div class="col-1 grid-margin stretch-card"></div>
<?php include '../footer.php'; ?>