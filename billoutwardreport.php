<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
require 'connect.php';

// Get start and end dates from the user (you can get these values from a form)
$startDate = $_POST['start_date']; // Replace with your form field name
$endDate = $_POST['end_date']; // Replace with your form field name

// Fetch data from the database between start and end dates
$sql = "SELECT billno, date, name, totalamount, paid , balance FROM billoutward WHERE date BETWEEN '$startDate' AND '$endDate'";
$result = $conn->query($sql);

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Your Name")
    ->setLastModifiedBy("Your Name")
    ->setTitle("Bill Data")
    ->setSubject("Bill Data")
    ->setDescription("Bill Data")
    ->setKeywords("excel php")
    ->setCategory("PHPExcel");

// Add headers to the Excel file
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Bill No')
    ->setCellValue('B1', 'Date')
    ->setCellValue('C1', 'Name')
    ->setCellValue('D1', 'Total')
    ->setCellValue('E1', 'Paid')
    ->setCellValue('F1', 'Balance');

// Add data to the Excel file
$rowNumber = 2; // Start from row 2 to leave space for headers
while ($row = $result->fetch_assoc()) {
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $rowNumber, $row['billno'])
        ->setCellValue('B' . $rowNumber, $row['date'])
        ->setCellValue('C' . $rowNumber, $row['name'])
        ->setCellValue('D' . $rowNumber, $row['total'])
        ->setCellValue('E' . $rowNumber, $row['paid'])
        ->setCellValue('F' . $rowNumber, $row['balance']);

    $rowNumber++;
}

// Save Excel file
$filename = 'bill_data_' . date('YmdHis') . '.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filename);

// Download the file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
exit;
?>