<?php
include('../connect.php');
require_once './vendor/autoload.php'; // Include the PhpSpreadsheet autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

$sql = "SELECT * FROM subsidy BETWEEN '$startDate' AND '$endDate'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Create a new PhpSpreadsheet instance
    $spreadsheet = new Spreadsheet();

    // Create a worksheet and set column headers
    $worksheet = $spreadsheet->getActiveSheet();
    $headers = array_keys($result->fetch_assoc());
    $col = 'A';
    foreach ($headers as $header) {
        $worksheet->setCellValue($col . '1', $header);
        $col++;
    }

    // Add data to the worksheet
    $row = 2;
    while ($row_data = $result->fetch_assoc()) {
        $col = 'A';
        foreach ($row_data as $value) {
            $worksheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    // Save the spreadsheet to a file
    $filename = 'exported_data.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    // Send the file to the browser for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
} else {
    echo "No records found within the specified date range.";
}

$con->close();
?>
