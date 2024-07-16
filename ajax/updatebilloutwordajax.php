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
$id = $_POST['id'];
// $id = $_POST['bill_id']; 

$sqlUpdate = "UPDATE `billoutward` SET `date` = ?, `name` = ?, `phone` = ?, `particulars` = ?, `quantity` = ?, `MRP` = ?, `amount` = ?, `totalamount` = ?, `paid` = ?, `balance` = ? WHERE `billno` = ?";
$stmtUpdate = $con->prepare($sqlUpdate);
$stmtUpdate->bind_param("ssssssssssi", $billDate, $name, $phno, $item, $quantity, $MRP, $amount, $grandTotal, $paid, $balance, $id);
$queryUpdate = $stmtUpdate->execute();
$stmtUpdate->close();

if ($queryUpdate) {
    echo json_encode(["success" => true, "message" => "Transaction updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update transaction"]);
}
?>
