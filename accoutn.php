<?php
session_start();
$uid = $_SESSION['uid'];

if (!$uid) {
    header("Location: index.php");
    exit();
}
include 'link.php';
include 'connect.php';
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            /* max-width: 800px; */
            margin: 0 auto;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            width: 100%;
            margin-top: 30px;
        }

        label {
            width: 100%;
            font-size: 20px;
            margin-top: 20px;
            /* width: calc(33% - 10px);  */
        }

        .common-input {
            /* width: 100%; */
            margin-bottom: 20px;
            border: 2px solid #318EC8;
            border-radius: 8px;
            padding: 8px;
            box-sizing: border-box;
            width: 300px;
            height: 40px;
            /* width: calc(33% - 10px); */
        }

        .line {
            width: 100%;
            height: 1px;
            background-color: #ddd;
            margin: 10px 0;
        }

        button {
            background-color: #318EC8 !important;
            color: white !important;
            border-radius: 10px !important;
            width: 110px !important;
            height: 40px !important;
            font-size: 15px !important;
            border: 2px solid #318EC8 !important;
            margin-right: 300px !important;
            margin-top: 30px !important;
            /* Adjusted margin-top */
        }

        body {
            overflow: hidden;
        }
    </style>

    <title>Account Form</title>
</head>

<body>
    <div class="container" id="myinput">


        <form action="" method="post">
            <div class="col-md-9">
                <h1 style="margin-left:20px;">Expenses</h1>
            </div>
            <div class="line"></div>

            <!-- Input fields with common class -->
            <div class="col-md-4">
                <label for="date">Date:</label>
                <input type="date" class="common-input" id="date" name="date" required>
            </div>

            <div class="col-md-4">
                <label for="particulars">Particulars:</label>
                <input type="text" class="common-input" id="particulars" name="particulars" required>
            </div>

            <div class="col-md-4">
                <label for="amount">Amount:</label>
                <input type="number" class="common-input" id="amount" name="amount" required>
            </div>
            <div class="col-md-4">
                <label for="investors">Investors:</label>
                <select id="Investors" class="common-input" name="investors">
                    <option value="Select">Select</option>
                    <option value="GSI">GSI</option>
                    <option value="USG">USG</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="investtotal">Investor Total:</label>
                <input type="number" class="common-input" id="usgAmount" name="usgAmount" required>
            </div>


            <div class="line"></div> <!-- Horizontal line separating general and Cash detail sections -->

            <h2 style="margin-left:20px;">Cash detail</h2>

            <div class="line"></div> <!-- Horizontal line separating Cash detail and the rest -->

            <!-- Input fields with common class -->

            <div class="col-md-4">
                <label for="cash">Cash in company:</label>
                <input type="text" class="common-input" id="cash" name="cash" required>
            </div>

            <div class="col-md-4">
                <label for="expence">Total expense:</label>
                <input type="text" class="common-input" id="expence" name="expence" required>
            </div>
            <div class="col-md-4">

                <label for="pigmi">Pigmi Amount:</label>
                <input type="text" class="common-input" id="pigmi" name="pigmi" required>

            </div>

            <div class="col-md-4">
                <label for="balance">Bank balance:</label>
                <input type="text" class="common-input" id="balance" name="balance" required>
            </div>

            <div class="col-md-4">
                <label for="stock">Stock in shop:</label>
                <input type="text" class="common-input" id="stock" name="stock" required>
            </div>

            <div class="col-md-8">
                <button type="submit" class="button" id="account">Save</button>
            </div>

        </form>

    </div>

</body>


<?php

$con = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch the current value of investortotal
$getInvestorTotalQuery = "SELECT investtotal FROM expenses ORDER BY id DESC LIMIT 1";
$result = $con->query($getInvestorTotalQuery);

// Initialize variables to avoid undefined variable warnings
$currentInvestorTotal = 0;

if ($result && $row = $result->fetch_assoc()) {
    $currentInvestorTotal = $row['investtotal'];
}

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $particulars = $_POST["particulars"];
    $amount = $_POST["amount"];
    $investors = isset($_POST["investors"]) ? $_POST["investors"] : "";
    $cash = $_POST["cash"];
    $expence = $_POST["expence"];
    $pigmi = $_POST["pigmi"];
    $balance = $_POST["balance"];
    $stock = $_POST["stock"];

    // Calculate the new investortotal
    $newInvestorTotal = floatval($currentInvestorTotal) + floatval($investors);

    // Insert data into the database
    $query = "INSERT INTO expenses (date, particularas, amount, investors, investtotal, cash, expence, pigmi, balance, stock) 
              VALUES ('$date', '$particulars', '$amount', '$investors', '$newInvestorTotal', '$cash', '$expence', '$pigmi', '$balance', '$stock')";

    if ($con->query($query) === TRUE) {
        echo '<script>alert("Record inserted successfully");</script>';
    } else {
        echo "Error: " . $query . "<br>" . $con->error;
    }
}

// Close the database connection
$con->close();
?>

<?php
include 'footer.php';
?>

</html>