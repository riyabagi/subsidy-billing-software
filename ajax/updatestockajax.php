<?php
include('../connect.php');

$particulars = $_POST["particulars"];
$units = $_POST["units"];
$stocks = $_POST["stocks"];
$ndp = $_POST["ndp"];
$mrp = $_POST["mrp"];

$id = $_POST["id"] ?? '';

$sql = "UPDATE stocks SET particulars=?, units=?, mrp=?, stocks=?, ndp=? WHERE sno=?";
    
$stmt = $con->prepare($sql);

$stmt->bind_param("sssssi", $particulars, $units, $mrp, $stocks, $ndp, $id);

$res = $stmt->execute();

if ($res) {
    echo "Data is updated successfully";
} else {
    echo "Error updating data";
}
?>
