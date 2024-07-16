<?php
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

$sql = "INSERT INTO `subsidy` (`date`, `farmername`,`billno`, `billingamount`, `ndp`, `pyreceived`, `subsidyreceived`, `insentive`,`crop`,`outstanding`,`profit`,`totalpy`) VALUES (?, ?, ?, ?,?, ?, ?, ?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssssssssssss", $billDate, $name, $billnumber, $billamount, $ndp, $received, $subsidy, $insentive, $crop, $balance, $profit, $total);
$query0 = $stmt->execute();

if ($query0) {
    echo json_encode(["success" => true, "message" => "Transaction successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Transaction failed"]);
}

$stmt->close();
?>
