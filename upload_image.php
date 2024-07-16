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

// Function to handle image upload
function uploadImage($file) {
    $target_dir = "uploads/"; // Create a folder named "uploads" in the same directory as this script
    $target_file = $target_dir . basename($file["name"]);

    // Check if the file is an image
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        die("Sorry, only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        die("Error uploading file.");
    }
}

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $image_path = uploadImage($_FILES["image"]);

    // Insert the image details into the database
    $sql = "INSERT INTO images (image_name, image_data) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $image_name, $image_data);

    $image_name = $_FILES["image"]["name"];
    $image_data = file_get_contents($image_path);

    if ($stmt->execute()) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error uploading image to the database.";
    }

    $stmt->close();
}

$conn->close();
?>
