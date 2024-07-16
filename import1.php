<?php
include "sidebar.php";
// include "footer.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Import</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            margin-top:20vh;
            
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 30%;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="import.php" method="post" enctype="multipart/form-data">
        <label for="excelFile">Choose an Excel file:</label>
        <input type="file" name="excelFile" id="excelFile" accept=".xls, .xlsx" required>
        <button type="submit">Import Data</button>
    </form>
</body>
</html>
