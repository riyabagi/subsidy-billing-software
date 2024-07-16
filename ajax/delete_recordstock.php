<?php
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Perform the deletion from the database
    $deleteSql = "DELETE FROM stocks WHERE sno = $id";
    $result = $con->query($deleteSql);

    // You may want to check the result and handle it accordingly
    if ($result) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $con->error;
    }
}
?>
