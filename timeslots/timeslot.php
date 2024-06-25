<?php 
include '../menu.php'; 
include '../assets/phpmail/mail.php';
?>

<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  extract($_POST);
  $time_slot_day_name = dataClean($time_slot_day_name);
  $time_slot_name = dataClean($time_slot_name);
  $time_slot_start_time = dataClean($time_slot_start_time);
  $time_slot_end_time = dataClean($time_slot_end_time);
  $time_slot_barber_count = dataClean($time_slot_barber_count);

  $messages = array();

  if (empty($time_slot_day_name)) {
    $messages['time_slot_day_name'] = "Day name should be select..!";
  }
  if (empty($time_slot_name)) {
    $messages['time_slot_name'] = "Time slot should be select..!";
  }
  if (empty($time_slot_start_time)) {
    $messages['time_slot_start_time'] = "Time slot start time..!";
  }
  if (empty($time_slot_end_time)) {
    $messages['time_slot_end_time'] = "Time slot end time..!";
  }
  if (empty($time_slot_barber_count)) {
    $messages['time_slot_barber_count'] = "start time..!";
  }

    if (empty($messages)) {
      $db = dbConn();
      $sql = "INSERT INTO tbl_time_slots (time_slot_day_id, time_slot_name, time_slot_start_time, time_slot_end_time, 
      time_slot_barber_count) VALUES ('$time_slot_day_name','$time_slot_name','$time_slot_start_time',
       '$time_slot_end_time','$time_slot_barber_count')";

      $db->query($sql);
     
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
      <h4 class="card-title">Salon Staff</h4>
      <p class="card-description"> Add Time Slot Details </p>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
          <?php
          $db = dbConn();
          $sql = "SELECT * FROM  tbl_day";
          $result = $db->query($sql);
          ?>
          <label for="exampleInputName1">Select Day Name</label>
          <select type="text" class="form-control" id="exampleInputName1" name="time_slot_day_name">
            <option value="">--</option>
            <?php
            while ($row = $result->fetch_assoc()) {
              ?>
              <option value="<?= $row['day_id'] ?>" <?= @$designation == $row['day_id'] ? 'selected' : '' ?>>
                <?= $row['day_name'] ?>
              </option>
              <?php
            }
            ?>
          </select>
          <span class="text-danger"><?= @$messages['time_slot_day_name'] ?></span>
        </div>

        <div class="form-group">
          <label for="exampleInputName1">Type Name for the slot</label>
          <input type="text" class="form-control" id="exampleInputName1" name="time_slot_name"
            value="<?= @$time_slot_name ?>" placeholder="Enter the First Name">
          <span class="text-danger"><?= @$messages['time_slot_name'] ?></span>
        </div>

        <div class="form-group">
          <label for="exampleInputName1">Type Start Time</label>
          <input type="time" class="form-control" id="exampleInputName1" name="time_slot_start_time"
            value="<?= @$time_slot_start_time ?>" placeholder="Enter the Last Name">
          <span class="text-danger"><?= @$messages['time_slot_start_time'] ?></span>
        </div>

        <div class="form-group">
          <label for="exampleInputName1">Type End Time</label>
          <input type="time" class="form-control" id="exampleInputName1" name="time_slot_end_time" value="<?= @$time_slot_end_time ?>"
            placeholder="Enter the ID Number">
          <span class="text-danger"><?= @$messages['time_slot_end_time'] ?></span>
        </div>

        <div class="form-group">
          <label for="exampleInputName1">Enter barber count</label>
          <input type="text" class="form-control" id="exampleInputName1" name="time_slot_barber_count"
            value="<?= @$time_slot_barber_count ?>" placeholder="Enter the Address Line 1">
          <span class="text-danger"><?= @$messages['time_slot_barber_count'] ?></span>
        </div>

        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
<div class="col-1 grid-margin stretch-card"></div>
<?php include '../footer.php'; ?>