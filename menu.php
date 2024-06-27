<?php
ob_start();
session_start();
if (!isset($_SESSION['LogId'])) {
    header("Location:login.php");
} else {
  
}
include 'config.php';
include 'function.php';
$userrole = $_SESSION ['userrole'];

$menu = "users/$userrole.php";

include $menu;

?>