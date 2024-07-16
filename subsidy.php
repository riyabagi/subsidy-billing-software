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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

</head>

<body>
    <!-- <div class="container "> -->
    <main class="table1 scro">
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
                        <?php
                        $sql = "SELECT MAX(billno) AS max_bill_number FROM subsidy";
                        $result = $con->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $currentBillNumber = $row["max_bill_number"];
                            $nextBillNumber = $currentBillNumber + 1;
                            ?>

                            <input type="text" id="billnumber" class="underline" value="<?php echo $nextBillNumber; ?>">

                            <?php
                        } else {
                            // If there are no records yet, start from 1
                            echo '<input type="text" id="billnumber" class="underline" value="1">';
                        }
                        ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <p class="text-right">Bill Date</p>
                    </div>

                    <div class="col-md-6">
                        <input type="date" id="billDate" class="underline" value="<?php echo date('Y-m-d'); ?>"
                            oninput="updateCurrentDate()">
                    </div>

                </div>

            </div>
        </div>
        <hr>
        <div class="up" style="margin-bottom: 10px;">
            <div class="row">
                <div class="col-md-4">
                    <label for="name">Farmer Name:</label>
                    <input type="text" id="name" class="name">
                </div>
                <div class="col-md-4">
                    <label for="name">Type of Crop </label>
                    <input type="text" id="crop" class="name">
                </div>

            </div>

        </div>

        <h5>Pricing</h5>
        <hr>

        <!-- <h6>MRP</h6> -->

        <div class="row">
            <div class="col-md-4">
                <label for="name">NDP Amount</label>
                <input type="text" id="ndp" class="name" oninput="calculateTotal(),calculatePtofit()">
            </div>

            <div class="col-md-4">
                <label for="name">Subsidy Recieved</label>
                <input type="text" id="subsidy1" class="name">
            </div>
            <div class="col-md-4">
                <label for="name"> Company Insentive</label>
                <input type="text" id="insentive" class="name" oninput="calculateTotal()">
            </div>
        </div>

        <h6 style="margin-top: 20px">Total Amount</h6>

        <div class="row">
            <div class="col-md-4">
                <label for="amount">Bill Amount</label>
                <input type="text" id="billamount" class="name" oninput="calculateBalance()">
            </div>
            <div class="col-md-4">
                <label for="recieved">Payment Received</label>
                <input type="text" id="received" class="name" oninput="calculateBalance(),calculateTotal()">
            </div>
            <div class="col-md-4">
                <label for="balance">Balance</label>
                <input type="text" id="balance" class="name" readonly>
            </div>
            <div class="col-md-4">
                <label for="recieved">Total</label>
                <input type="text" id="total" class="name" oninput="calculateBalance()">
            </div>
            <div class="col-md-4">
                <label for="balance">Profit</label>
                <input type="text" id="profit" class="name">
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
                // var ndpAmount = parseFloat(document.getElementById('ndp').value) || 0;
                var insentive = parseFloat(document.getElementById('insentive').value) || 0;
                var paymentReceived = parseFloat(document.getElementById('received').value) || 0;

                var total = insentive + paymentReceived;

                document.getElementById('total').value = total.toFixed(2);

                calculatePtofit();
            }

            function calculatePtofit() {
                var ndpAmount = parseFloat(document.getElementById('ndp').value) || 0;
                var total = parseFloat(document.getElementById('total').value) || 0;

                var profit = ndpAmount - total;

                document.getElementById('profit').value = profit.toFixed(2);
            }
        </script>

        <span style="color:red;" id="error"></span>
        <br>
        <button type="submit" class="buttons" id="subsidysave">Save</button>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Function to convert table data to Excel
                function exportToExcel() {
                    var table = document.querySelector("table");
                    var ws = XLSX.utils.table_to_sheet(table);
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    var filename = "subsidy_list.xlsx";
                    XLSX.writeFile(wb, filename);
                }

                // Attach click event to the export button
                var exportBtn = document.getElementById("toExcel");
                exportBtn.addEventListener("click", exportToExcel);
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#subsidysave").click(function () {

                    let billnumber = $("#billnumber").val();
                    let billDate = $("#billDate").val();
                    let name = $("#name").val();
                    let crop = $("#crop").val();
                    let ndp = $("#ndp").val();
                    let subsidy = $("#subsidy1").val();
                    let insentive = $("#insentive").val();
                    let billamount = $("#billamount").val();
                    let received = $("#received").val();
                    let balance = $("#balance").val();
                    let total = $("#total").val();
                    let profit = $("#profit").val();

                    if (name == '') {
                        $("#error").html("Please Enter The Name")
                    } else if (crop == '') {
                        $("#error").html("Enter The Type Of Crop")
                    } else if (insentive == '') {
                        $("#error").html("Enter the Insentive")
                    } else if (ndp == '') {
                        $("#error").html("Enter ndp")
                    } else if (billamount == '') {
                        $("#error").html("Enter Total Amount")
                    } else {
                        $.ajax({
                            url: './ajax/subsidyajax.php',
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
                            },
                            success: function (res) {
                                try {
                                    var response = JSON.parse(res);
                                    if (response.success) {
                                        alert('Saved successful');
                                        window.location.href = "subsidylist.php";
                                    } else {
                                        alert('Error Saving: ' + response.message);
                                    }
                                } catch (e) {
                                    console.error('Error parsing JSON response', e);
                                }
                            },
                            error: function (err) {
                                console.error('Error in AJAX request', err);
                            }
                        });
                    }
                });
            });
        </script>
    </main>
    </div>

</body>

</html>