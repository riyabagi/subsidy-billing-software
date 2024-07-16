<?php
session_start();
include('../connect.php');

$lemail = $_POST['lemail'];
$lpss = $_POST['lpss'];

$sql = "SELECT * FROM `login` WHERE `email` = ? AND `password` = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $lemail, $lpss);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['uid'];
    $_SESSION['uid'] = $id; 
    echo 'success';
} else {
    echo "user not found";
}


$stmt->close();
$con->close();

?>