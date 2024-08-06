<?php


if (!isset($_SESSION['LogId'])) {
    header("Location:login.php");
} else {
  
}

$userrole = $_SESSION ['userrole'];

$dashboard = "dashboard/$userrole.php";

include $dashboard;

?>