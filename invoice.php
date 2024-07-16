<?php

session_start();
$uid = $_SESSION['uid'];

if (!$uid) {
    header("Location: index.php");
    exit();
}

include 'link.php';
include 'connect.php';
// include 'sidebar.php';

// Get the bill ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    die("Invalid or missing invoice ID");
}

// Fetch other details from the database based on the ID
$sql = "SELECT * FROM billoutward WHERE billno = $id";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error fetching bill details: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("No results found for the given invoice ID");
}

$date = isset($row['date']) ? $row['date'] : '';
$name = isset($row['name']) ? $row['name'] : '';
$phno = isset($row['phone']) ? $row['phone'] : '';
$items = isset($row['particulars']) ? json_decode($row['particulars'], true) : [];
$quantity = isset($row['quantity']) ? json_decode($row['quantity'], true) : [];
$MRP = isset($row['MRP']) ? json_decode($row['MRP'], true) : [];
$amount = isset($row['amount']) ? json_decode($row['amount'], true) : [];
$grandTotal = isset($row['totalamount']) ? $row['totalamount'] : '';
$paid = isset($row['paid']) ? $row['paid'] : '';
$balance = isset($row['balance']) ? $row['balance'] : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <hr>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        p {
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #d4ba60;
            color: #fff;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .total {
            font-weight: bold;
        }

        .invoice-summary {
            margin-top: 20px;
            margin-right: 30px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        /* Media query to hide the print button when printing */
        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Invoice</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h3>Shivshakti Traders</h3>
                <p>Location:</p>
                <p>Bill NO: <?php echo htmlspecialchars($id); ?></p>
            </div>

            <div class="col-md-6">
                <p>Bill Date: <?php echo $date; ?></p>
                <p>Customer: <?php echo $name; ?></p>
                <p>Phone No: <?php echo $phno; ?></p>
            </div>
        </div>
        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Quantity</th>
                    <th>MRP</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $item): ?>
                    <tr>
                        <td><?php echo $item; ?></td>
                        <td><?php echo $quantity[$index]; ?></td>
                        <td><?php echo $MRP[$index]; ?></td>
                        <td><?php echo $amount[$index]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="invoice-summary">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="total">
                        <span>Grand Total:</span>
                        <span><?php echo $grandTotal; ?></span>
                    </div>
                    <div class="paid">
                        <span>Paid:</span>
                        <span><?php echo $paid; ?></span>
                    </div>
                    <div class="balance">
                        <span>Balance:</span>
                        <span><?php echo $balance; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <button class="buttons" onclick="printInvoice()">Print</button>
    </div>

    <div class="footer"></div>

    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</body>

</html>