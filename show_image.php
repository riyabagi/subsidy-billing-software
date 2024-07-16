<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traders";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the last uploaded image
$sql = "SELECT * FROM images ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-type: image/jpeg"); // Change the content type based on the image type
    echo $row["image_data"];
} else {
    echo "No images found.";
}

$conn->close();
?>
