<?php ob_start(); ?>
<?php include 'function.php'; ?>
<?php include 'config.php'; ?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?= SYSTEM_PATHS ?>assets/js/sweetalert2.all.js"></script>
    <style>
        body {
            background-color: rgb(200, 200, 200);
        }

        .login-container {
            font-family: "Trirong", serif;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <?php
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        $username = dataClean($username);
        $password = dataClean($password);

        $messages = array();

        if (empty($username)) {
            $messages['username'] = "The User Name should not be empty ..!";
        }

        if (!empty($username)) {
            $db = dbConn();
            $sql = "SELECT * FROM  tbl_staff WHERE staff_username='$username' AND staff_status='1'";
            //database eke thiyena user name ekai enter karapu username ekai eka samanada balanawa
            $result = $db->query($sql);
            //database eke value ekak thiyenawanam statement eka athule thiyena de wenawa
            if ($result->num_rows > 0) {
                //result eka null nemeida kiyala balanawa meken
                $psw = sha1($password);
                //create new variable and encrypt karanawa danata databse eke thiyena password eka
                $rowpsw = $result->fetch_assoc();
                $sqlpw1 = $rowpsw['staff_password'];
                if ($psw === $sqlpw1) {
                    $_SESSION['LogId'] = $rowpsw['staff_id'];
                    $_SESSION['LogTitle'] = $rowpsw['staff_title'];
                    $_SESSION['LogGender'] = $rowpsw['staff_gender'];
                    $_SESSION['LogDesignation'] = $rowpsw['staff_designation'];
                    $_SESSION['LoggedDesignation'] = $rowpsw['staff_designation'];
                    $_SESSION['LogFirstname'] = $rowpsw['staff_firstname'];
                    $_SESSION['LogLastname'] = $rowpsw['staff_lastname'];
                    $_SESSION['LogIdnum'] = $rowpsw['staff_idnum'];
                    $_SESSION['LogAddressline1'] = $rowpsw['staff_addressline1'];
                    $_SESSION['LogAddressline2'] = $rowpsw['staff_addressline2'];
                    $_SESSION['LogEmail'] = $rowpsw['staff_email'];
                    $_SESSION['LogTelNo'] = $rowpsw['staff_telno'];
                    $_SESSION['LogDes'] = $rowpsw['staff_description'];
                    $_SESSION['LogImg'] = $rowpsw['staff_image'];
                    $_SESSION['LogUserName'] = $rowpsw['staff_username'];
                    $_SESSION['LogPasw'] = $rowpsw['staff_password'];
                    $new = $_SESSION['LogDesignation'];

                   $sql2 = "SELECT * FROM  designation WHERE designation_id='$new'";

                        $user = $_SESSION['LogId'];
                        $AtendDate = date('Y-m-d');
                        $AttendUserRole = $_SESSION['LoggedDesignation'];
                        $sql3 = "SELECT * FROM  tbl_attendance WHERE logged_user_id='$user'";
                        $result3 = $db->query($sql3);

                        if ($result3->num_rows > 0) {
                            "user already created";
                        }else{
                            $sql4 = "INSERT INTO tbl_attendance (logged_user_id, attend_user_role, attend_date) VALUES 
                            ('$user','$AttendUserRole','$AtendDate')";
                            $db->query($sql4);
                        }
                    
                    $result1 = $db->query($sql2);
                    //row1 is a array
                    $row1 = $result1->fetch_assoc();
                    //create a variable name and assign it to row1
                    $userrole = $row1['designation_name'];
                    //create a session and asign the userrole variable to it
                    $_SESSION['userrole'] = $userrole;
                    echo "<script>
        Swal.fire({
            title: 'Logged in!',
            text: 'Login Successful !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/system/index.php'; // Redirect to success page
        });
</script>";   
                    //create karapu encrypt wunu eke thiyena encrypt password ekai databse eke encrypt password ekai samanada kiyala balanawa ehema nam password matching if not password are not matched
                } else {
                    $messages['password'] = "The Password is wrong";
                }
            } else {
                $messages['username'] = "This username is not in the database";
            }

        }

        if (empty($password)) {
            $messages['password'] = "The Password Should not be empty";
        }
    }
    ?>

    <div class="login-container">
        <h1 class="text-center">Staff Member Login</h1>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <label for="text" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= @$username ?>"
                    placeholder="Enter the Username">
                <span class="text-danger"><?= @$messages['username'] ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter the Password">
                <span class="text-danger"><?= @$messages['password'] ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>