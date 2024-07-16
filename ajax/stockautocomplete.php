<?php
include('../connect.php');

$term = $_POST['term'];
$sql = "SELECT DISTINCT particulars FROM stock WHERE particulars LIKE ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();

$particulars = array();
while ($row = $result->fetch_assoc()) {
    $particulars[] = $row['particulars'];
}

echo json_encode($particulars);
?>