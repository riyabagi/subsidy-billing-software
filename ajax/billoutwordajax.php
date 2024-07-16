<?php
include('../connect.php');

$billDate = $_POST['billDate'];
$name = $_POST['name'];
$phno = $_POST['phno'];
$item = json_encode($_POST['item']);
$quantity = json_encode($_POST['quantity']);
$MRP = json_encode($_POST['MRP']);
$amount = json_encode($_POST['amount']);
$grandTotal = $_POST['grandTotal'];
$paid = $_POST['paid'];
$balance = $_POST['balance'];

$sql = "INSERT INTO billoutward (date, name, phone, particulars, quantity, MRP, amount, totalamount, paid, balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ssssssssss", $billDate, $name, $phno, $item, $quantity, $MRP, $amount, $grandTotal, $paid, $balance);
$query0 = $stmt->execute();

if ($query0) {
    // Get the last inserted ID, which is the billno
    $billno = $stmt->insert_id;
    echo json_encode(["success" => true, "message" => "Transaction successful", "billno" => $billno]);
} else {
    echo json_encode(["success" => false, "message" => "Transaction failed"]);
}

$stmt->close();
?>
