<?php
require 'vendor/autoload.php'; // Load PhpSpreadsheet library

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traders1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excelFile"])) {
    // Upload the Excel file
    $excelFile = $_FILES["excelFile"]["tmp_name"];

    // Load the Excel file
    $spreadsheet = IOFactory::load($excelFile);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Assuming the first row contains column names
    $columns = array_shift($sheetData);

    // Map column names to their respective indexes
    $columnIndexes = array_flip($columns);

    // Extract data from specific columns
    $dataToInsert = [];
    foreach ($sheetData as $data) {
        $particulars = $data[$columnIndexes['Particulars']];
        $unit = $data[$columnIndexes['Unit']];
        $stock = $data[$columnIndexes['Stocks']];
        $ndp = $data[$columnIndexes['NDP']];
        $mrp = $data[$columnIndexes['MRP']];

        // Add the data to the array for insertion
        $dataToInsert[] = [$particulars, $unit, $stock, $ndp, $mrp];
    }

    // Prepare SQL statement
    $sql = "INSERT INTO stocks (particulars, units, stocks, ndp, mrp) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare and execute SQL statement for each row
    $stmt = $conn->prepare($sql);

    foreach ($dataToInsert as $rowData) {
        $stmt->bind_param("sssss", ...$rowData);
        $stmt->execute();
    }

    $stmt->close();
    echo "Data imported successfully.";
}

$conn->close();
?>
