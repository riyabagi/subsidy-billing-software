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
    <title>Date Range Report</title>
    <style>
        body {
            background-color: #f2f2f2;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .report-form {
            /* margin: 40px; */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            height: 55vh;
            width: 50%;
        }

        .report-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .report-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .report-form button {
            background-color: #0077B5;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .report-form button:hover {
            background-color: #005689;

        }
    </style>
</head>

<body>
    <div class="container" style="">
        <div class="report-form">
            <h2 style="color:#318EC8"> Subsidy Generate Report</h2>
            <form id="reportForm">
                <div class="row">
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" required>

                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" required>

                    
                <span style="color:red;" id="error"></span>
                <br>

                    <button id="generate" type="button" onclick="generateReport()">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#generate").click(function () {
                console.log("inside");
                let startDate = $("#startDate").val();
                let endDate = $("#endDate").val();
                

                if (startDate == '') {
                    $("#error").html("Please Enter The Start Date")
                } else if (endDate == '') {
                    $("#error").html("Please Enter The End Date")
                } else {
                    $.ajax({
                        url: 'billoutwardreport.php',
                        method: "POST",
                        data: {
                            startDate: startDate,
                            endDate: endDate,
                        },
                        success: function (res) {
                            alert(res)
                            window.location.href = 'billoutward.php';
                        },
                        error: function (err) {

                        }

                    })

                }
            })
        })
    </script>

</body>

</html>