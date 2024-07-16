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
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        html {
            height: 100%;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            min-height: 500px;
            max-height: 80vh;
            overflow: auto;
            display: flex;
            flex-direction: column;
            transition: height 0.3s ease;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin: 8px 0;
            padding: 10px;
            font-size: 14px;
            border: 2px solid #318EC8;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            justify-content: space-between;
        }

        #billDate.underline {
            border-bottom: 2px solid #318EC8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: auto;
            border-radius: 10px;
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

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .buttons {
            background-color: #d4ba60;
            color: #fff;
            font-size: 14px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons:hover {
            background-color: #d4ba60;
        }

        .name {
            border: 2px solid #318EC8;
        }

        .underline {
            border-bottom: 2px solid #7accf8;
            width: 50%;
        }

        label {
            margin-top: 20px;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 768px) {
            .container {
                width: 90%;
            }

            input,
            select {
                width: 100%;
            }

            .button-container {
                flex-direction: column;
            }

            .buttons {
                width: 100%;
                margin-top: 10px;
            }

            .row {
                flex-direction: column;
            }

            .col-md-4,
            .col-md-6,
            .col-md-9,
            .col-md-3 {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container" id="container">

        <h1>Bill-Outward</h1>
        <hr>
        <div class="col-md-6">
            <input type="date" id="billDate" class="underline" value="<?php echo date('Y-m-d'); ?>"
                oninput="updateCurrentDate()">
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="name">Customer:</label>
                <input type="text" id="name" class="name">
            </div>
            <div class="col-md-4">
                <label for="name">Phone no </label>
                <input type="text" id="phno" class="name">
            </div>
        </div>
        <table id="itemTable">
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Quantity</th>
                    <th>MRP</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row-style">
                    <td><input type="text" name="item[]" placeholder="Particulars"></td>
                    <td><input type="number" name="quantity[]" placeholder="Quantity" min="0"
                            oninput="calculateRowAmount(this)"></td>
                    <td><input type="number" name="MRP[]" placeholder="MRP" min="0" oninput="calculateRowAmount(this)">
                    </td>
                    <td><input type="number" name="amount[]" placeholder="Amount" min="0" readonly></td>
                </tr>
            </tbody>
        </table>

        <div class="button-container">
            <button class="buttons" type="button" onclick="addRow()">Add Row</button>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="grandTotal">Grand Total:</label>
                <input class="total" id="total" type="number" name="grandTotal" placeholder="Grand Total"
                    oninput="calculateSum()">
            </div>
            <div class="col-md-4">
                <label for="paid">Paid:</label>
                <input class="total" id="paid" type="number" name="paid" placeholder="Paid" min="0"
                    oninput="calculateSum()">
            </div>
            <div class="col-md-4">
                <label for="balance">Balance:</label>
                <input class="total" id="balance" type="number" name="balance" placeholder="Balance" min="0" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <span style="color:red;" id="error"></span>
                <br>
                <button type="submit" class="buttons" id="save" style="margin-top:20px;">Save</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button type="button" class="buttons" id="invoice" onclick="redirectToInvoice()">Invoice</button>
            </div>
        </div>


        <script>
            function addRow() {
                var table = document.getElementById("itemTable").getElementsByTagName('tbody')[0];
                var newRow = table.insertRow(table.rows.length);
                newRow.classList.add("row-style");

                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);
                var cell4 = newRow.insertCell(3);

                cell1.innerHTML = '<input type="text" name="item[]" placeholder="Particulars">';
                cell2.innerHTML = '<input type="number" name="quantity[]" placeholder="Quantity" min="0" oninput="calculateRowAmount(this)">';
                cell3.innerHTML = '<input type="number" name="MRP[]" placeholder="MRP" min="0" oninput="calculateRowAmount(this)">';
                cell4.innerHTML = '<input type="number" name="amount[]" placeholder="Amount" min="0" readonly>';

                adjustContainerHeight();
            }

            function adjustContainerHeight() {
                var container = document.getElementById("container");
                var height = container.scrollHeight;
                container.style.height = height + "px";
            }
            function calculateRowAmount(input) {
                var row = input.closest('tr');
                var quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                var mrp = parseFloat(row.querySelector('input[name="MRP[]"]').value) || 0;
                var amount = quantity * mrp;
                row.querySelector('input[name="amount[]"]').value = amount.toFixed(2);

                calculateSum();
            }

            function calculateSum() {
                var grandTotalInput = document.querySelector('input[name="grandTotal"]');
                var paidInput = document.querySelector('input[name="paid"]');
                var balanceInput = document.querySelector('input[name="balance"]');
                var table = document.getElementById("itemTable").getElementsByTagName('tbody')[0];
                var rows = table.getElementsByTagName('tr');
                var totalAmount = 0;

                for (var i = 0; i < rows.length; i++) {
                    var amount = parseFloat(rows[i].querySelector('input[name="amount[]"]').value) || 0;
                    totalAmount += amount;
                }

                grandTotalInput.value = totalAmount.toFixed(2);

                var grandTotal = parseFloat(grandTotalInput.value) || 0;
                var paid = parseFloat(paidInput.value) || 0;
                var balance = grandTotal - paid;
                balanceInput.value = balance.toFixed(2);
            }
            function redirectToInvoice() {
                // Get values from the page
                var billDate = document.getElementById("billDate").value;
                var name = document.getElementById("name").value;
                var phno = document.getElementById("phno").value;
                var items = [];

                // Loop through table rows to get item details
                var tableRows = document.getElementById("itemTable").getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (var i = 0; i < tableRows.length; i++) {
                    var row = tableRows[i];
                    var item = {
                        'item': row.querySelector('input[name="item[]"]').value,
                        'quantity': row.querySelector('input[name="quantity[]"]').value,
                        'MRP': row.querySelector('input[name="MRP[]"]').value,
                        'amount': row.querySelector('input[name="amount[]"]').value
                    };
                    items.push(item);
                }

                var grandTotal = document.getElementById("total").value;
                var paid = document.getElementById("paid").value;
                var balance = document.getElementById("balance").value;

                // Encode data for URL
                var url = "invoice.php?" +
                    "date=" + encodeURIComponent(billDate) +
                    "&name=" + encodeURIComponent(name) +
                    "&phno=" + encodeURIComponent(phno) +
                    "&items=" + encodeURIComponent(JSON.stringify(items)) +
                    "&grandTotal=" + encodeURIComponent(grandTotal) +
                    "&paid=" + encodeURIComponent(paid) +
                    "&balance=" + encodeURIComponent(balance);

                // Redirect to the Invoice page
                window.location.href = url;
            }


        </script>

        <script>
            $(document).ready(function () {
                $("#save").click(function () {

                    let billDate = $("#billDate").val();
                    let name = $("#name").val();
                    let phno = $("#phno").val();
                    let item = $("input[name='item[]']").map(function () { return $(this).val(); }).get();
                    let quantity = $("input[name='quantity[]']").map(function () { return $(this).val(); }).get();
                    let Mrp = $("input[name='MRP[]']").map(function () { return $(this).val(); }).get();
                    let amount = $("input[name='amount[]']").map(function () { return $(this).val(); }).get();
                    let grandTotal = $("#total").val();
                    let paid = $("#paid").val();
                    let balance = $("#balance").val();

                    if (name == '') {
                        $("#error").html("Please Enter The Name")
                    } else if (phno == '') {
                        $("#error").html("Enter The Type Of Crop")
                    } else if (item == '') {
                        $("#error").html("Select at least 1 item")
                    } else if (quantity == '') {
                        $("#error").html("Select quantiy")
                    } else {
                        $.ajax({
                            url: './ajax/billoutwordajax.php',
                            method: "POST",
                            data: {
                                billDate: billDate,
                                name: name,
                                phno: phno,
                                item: item,
                                quantity: quantity,
                                MRP: Mrp,
                                amount: amount,
                                grandTotal: grandTotal,
                                paid: paid,
                                balance: balance,
                            },
                            success: function (res) {
                                console.log('Response from server:', res);

                                try {
                                    var response = JSON.parse(res);
                                    if (response.success) {
                                        alert('Saved successful');

                                        // Redirect to the Invoice page with the fetched billno
                                        window.location.href = "invoice.php?id=" + response.billno;
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
</body>

</html>