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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
$billDate = $_POST['billDate'];
    $name=$_POST['supplier'];
    $amount=$_POST['amount'];

    $sql= "INSERT INTO billinward( date, amount,supplier) VALUES ('$billDate','$amount','$name')";
    $res=$con->query($sql);
   if($res){
    echo "<script> alert('data is saved');
    window.location.href = 'accoutn.php';
    </script>";
   } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trades</title>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .inward {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        input {
            margin: 8px 0;
            padding: 10px;
            font-size: 14px;
            border: 2px solid #7accf8;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .underline {
            border-bottom: 2px solid #7accf8;
            width: 100%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .col {
            flex: 1;
            min-width: 0;
            margin-right: 10px;
        }

        .buttons {
            background-color: #d4ba60;
            color: #fff;
            font-size: 14px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons:hover {
            background-color: #d4ba60;
        }

        @media (max-width: 600px) {
            .inward {
                max-width: 100%;
            }

            .col {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="inward">
            <h1>Bill-Inward</h1>
            <hr>
            <from action="billin.php" method="post">
            <div class="row">
                <input type="date" id="billDate" class="underline" value="<?php echo date('Y-m-d'); ?>"
                    oninput="updateCurrentDate()">
            </div>
            <div class="row">
                <div class="col">
                    <input type="email" name="supplier" placeholder="Supplier">
                </div>
                <div class="col">
                    <input type="amount" name="amount"placeholder="Amount">
                </div>
            </div>
            <button type="submit" class="buttons" id="subsidysave">Save</button>
    </from>
        </div>
    </div>

</body>

</html>