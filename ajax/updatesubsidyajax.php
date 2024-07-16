<?php
// session_start();
// $uid = $_SESSION['uid'];
include('../connect.php');

$billnumber = $_POST['billnumber'];
$billDate = $_POST['billDate'];
$balance = $_POST['balance'];
$name = $_POST['name'];
$crop = $_POST['crop'];
$ndp = $_POST['ndp'];
$subsidy = $_POST['subsidy'];
$insentive = $_POST['insentive'];
$billamount = $_POST['billamount'];
$received = $_POST['received'];
$profit = $_POST['profit'];
$total = $_POST['total'];
$id = $_POST['id'];

$sqlll = "UPDATE `subsidy` SET `billingamount`='$billamount', `ndp`='$ndp', `pyreceived`='$received', `subsidyreceived`='$subsidy', `insentive`='$insentive', `totalpy`='$total', `outstanding`='$balance', `profit`='$profit' WHERE `sno`='$id'";
$queryyy = mysqli_query($con, $sqlll);

if ($queryyy) {
    echo "Saved successful!";
} else {
    echo "Failed to save";
}