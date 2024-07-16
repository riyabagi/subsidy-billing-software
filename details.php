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
    <title>trades</title>

    <style>
        main.table1 {
            margin: 20px;
            width: calc(100% - 100px);
            max-height: 85vh;
            overflow-y: auto;
            background-color: #fff5;
            backdrop-filter: blur(7px);
            box-shadow: 0 .4rem .8rem #0005;
            border-radius: .8rem;
            padding: 20px;
        }

        .scro {
            width: 95%;
            background-color: #fffb;
            margin: .8rem auto;
            border-radius: .6rem;
            overflow: auto;
        }

        .scro::-webkit-scrollbar {
            width: 0.5rem;
            height: 0.5rem;
        }

        .scro::-webkit-scrollbar-thumb {
            border-radius: .5rem;
            background-color: #0004;
        }

        .scro::-webkit-scrollbar-thumb:hover {
            background-color: #0007;
        }
    </style>
</head>

<body>

    <?php
    include('connect.php');
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $sqlProduct = "SELECT * FROM subsidy WHERE sno = $id";
    $resultProduct = mysqli_query($con, $sqlProduct);

    if (!$resultProduct) {
        die("Error in SQL query: " . mysqli_error($con));
    }


    ?>
    <!-- <div class="container "> -->
    <main class="table1 scro">

        <?php
        while ($row = mysqli_fetch_assoc($resultProduct)) {

            $farmerName = $row['farmername'] ?? '';
            $crop = $row['crop'] ?? '';
            $ndp = $row['ndp'] ?? '';
            $subsidy = $row['subsidyreceived'] ?? '';
            $companyinsentive = $row['insentive'] ?? '';
            $billamount = $row['billingamount'] ?? '';
            $paymentrecieved = $row['pyreceived'] ?? '';
            $balance = $row['outstanding'] ?? '';
            $total = $row['totalpy'] ?? '';
            $profit = $row['profit'] ?? '';
            $billnumber = $row['billno'] ?? '';
            $billdate = $row['date'] ?? '';
            ?>
            <h1 style="color:#333333;">Subsidy</h1>
            <div class="row mt-2">
                <div class="col-md-8"></div>
                <div class="col-md-4 tet">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <p class="text-right">Bill Number</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="billnumber" class="underline" value="<?= $billnumber ?>" readonly>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <p class="text-right">Bill Date</p>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-6">
                                <input type="text" id="billDate" class="underline" style="width: 175px"
                                    value="<?= $billdate ?>" readonly>
                            </div>

                        </div>

                    </div>
                </div>
                <hr>
                <div class="up" style="margin-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="balance">Framer Name</label>
                            <input type="text" id="name" class="name" value="<?= $farmerName ?>" readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="name">Type of Crop </label>
                            <input type="text" id="crop" class="name" value="<?= $crop ?>" readonly>
                        </div>

                    </div>

                </div>

                <h5>Pricing</h5>
                <hr>

                <!-- <h6>MRP</h6> -->

                <div class="row">
                    <div class="col-md-4">
                        <label for="name">NDP Amount</label>
                        <input type="text" id="ndp" class="name" oninput="calculateTotal()" value="<?= $ndp ?>">
                    </div>

                    <div class="col-md-4">
                        <label for="name">Subsidy Recieved</label>
                        <input type="text" id="subsidy" class="name" value="<?= $subsidy ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="name"> Company Insentive</label>
                        <input type="text" id="insentive" class="name" oninput="calculateTotal()"
                            value="<?= $companyinsentive ?>">
                    </div>
                </div>

                <h6 style="margin-top: 20px">Total Amount</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label for="amount">Bill Amount</label>
                        <input type="text" id="billamount" class="name" oninput="calculateBalance()"
                            value="<?= $billamount ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="recieved">Payment Received</label>
                        <input type="text" id="received" class="name" oninput="calculateBalance(),calculateTotal()"
                            value="<?= $paymentrecieved ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="balance">Balance</label>
                        <input type="text" id="balance" class="name" value="<?= $balance ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="recieved">Total</label>
                        <input type="text" id="total" class="name" oninput="calculateBalance()" value="<?= $total ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="balance">Profit</label>
                        <input type="text" id="profit" class="name" value="<?= $profit ?>" readonly>
                    </div>
                </div>

                <script>
                    function calculateBalance() {
                        var amount = parseFloat(document.getElementById('billamount').value) || 0;
                        var received = parseFloat(document.getElementById('received').value) || 0;
                        var balance = amount - received;

                        document.getElementById('balance').value = balance.toFixed(2);
                    }

                    function updateCurrentDate() {

                        var selectedDate = document.getElementById('currentDate').value;
                        console.log("Selected Date:", selectedDate);
                    }

                    function calculateTotal() {
                        var ndpAmount = parseFloat(document.getElementById('ndp').value) || 0;
                        var subsidyReceived = parseFloat(document.getElementById('insentive').value) || 0;
                        var paymentReceived = parseFloat(document.getElementById('received').value) || 0;

                        var total = ndpAmount + subsidyReceived + paymentReceived;

                        document.getElementById('total').value = total.toFixed(2);
                    }
                </script>

                <span style="color:red;" id="error"></span>
                <br>
                <button type="submit" class="buttons" id="subsidydeetailssave">Save</button>

                <script>
                    $(document).ready(function () {
                        $("#subsidydeetailssave").click(function () {
                            console.log("inside");
                            let billnumber = $("#billnumber").val();
                            let billDate = $("#billDate").val();
                            let name = $("#name").val();
                            let crop = $("#crop").val();
                            let ndp = $("#ndp").val();
                            let subsidy = $("#subsidy").val();
                            let insentive = $("#insentive").val();
                            let billamount = $("#billamount").val();
                            let received = $("#received").val();
                            let balance = $("#balance").val();
                            let total = $("#total").val();
                            let profit = $("#profit").val();
                            let id = <?= json_encode($id) ?>;

                            if (name == '') {
                                $("#error").html("Please Enter The Name")
                            } else if (crop == '') {
                                $("#error").html("Enter The Type Of Crop")
                            }
                            //  else if (insentive == '') {
                            //     $("#error").html("Enter the Insentive")
                            // } else if (ndp == '') {
                            //     $("#error").html("Enter ndp")
                            // } else if (billamount == '') {
                            //     $("#error").html("Enter Total Amount")
                            // }
                            else {
                                $.ajax({
                                    url: './ajax/updatesubsidyajax.php',
                                    method: "POST",
                                    data: {
                                        billnumber: billnumber,
                                        billDate: billDate,
                                        name: name,
                                        crop: crop,
                                        ndp: ndp,
                                        subsidy: subsidy,
                                        insentive: insentive,
                                        billamount: billamount,
                                        received: received,
                                        balance: balance,
                                        total: total,
                                        profit: profit,
                                        id: id,
                                    },
                                    success: function (res) {
                                        alert(res)
                                        window.location.href = 'subsidylist.php';
                                    },
                                    error: function (err) {

                                    }

                                })

                            }
                        })
                    })
                </script>

            <?php }
        ; ?>
    </main>
    </div>
</body>


</html>