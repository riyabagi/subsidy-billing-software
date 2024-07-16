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
    <title>Document</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: serif; */
        }

        .body1 {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            /* align-items: center; */
            /* background: url(assets/img/8.jpg) center / cover; */
        }


        main.table {
            margin: 20px;
            width: calc(100% - 100px);
            height: 87vh;
            background-color: #fff5;
            backdrop-filter: blur(7px);
            box-shadow: 0 .4rem .8rem #0005;
            border-radius: .8rem;
            overflow: hidden;
        }

        .table_header {
            width: 100%;
            height: 10%;
            background-color: rgba(0, 0, 0, 0.3);
            padding: .8rem 1rem;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table_header .input-group {
            width: 35%;
            height: 100%;
            background: #fff5;
            padding: 0 .8rem;
            border-radius: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: .2s;
        }

        .table_header .input-group:hover {
            width: 45%;
            background: #fff8;
            box-shadow: 0 .1rem .4rem #0002;
        }

        .table_header .input-group i {
            width: 1.2rem;
            height: 1.2rem;
            margin-left: 0.5rem;
            cursor: pointer;
        }

        .table_header .input-group input[type="search"] {
            flex: 1;
            padding: 0 .5rem 0 .3rem;
            background-color: transparent;
            border: none;
            outline: none;
        }

        .table_body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(132, 133, 132, 0.05);
            border-radius: .6rem;
            z-index: -1;
        }

        .table_body {
            width: 95%;
            max-height: calc(89% - 1.6rem);
            background-color: rgba(132, 133, 132, 0.05);
            margin: .8rem auto;
            border-radius: .6rem;
            overflow: auto;
            position: relative;
        }

        .table_body::-webkit-scrollbar {
            width: 0.5rem;
            height: 0.5rem;
        }

        .table_body::-webkit-scrollbar-thumb {
            border-radius: .5rem;
            background-color: #0004;
            visibility: hidden;
        }

        .table_body:hover::-webkit-scrollbar-thumb {
            visibility: visible;
        }

        table {
            width: 100%;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            padding: 1rem;
            text-align: left;
        }

        thead th {
            position: sticky;
            top: 0;
            left: 0;
            background-color: #d5d1defe;
        }

        tbody tr:nth-child(even) {
            background-color: #0000000b;
        }

        tbody tr {
            --delay: .1s;
            transition: .5s ease-in-out var(--delay), background-color 0s;
        }

        tbody tr.hide {
            opacity: 0;
            transform: translateX(100%);
        }

        tbody tr:hover {
            background-color: #fff6;
        }

        tbody tr td,
        tbody tr td p,
        tbody tr td i {
            transition: .2s ease-in-out .5s;
        }

        tbody tr.hide td,
        tbody tr.hide td p {
            padding: 0;
            font: 0/0 sans-serif;
            transition: .2s ease-in-out .5s;
        }

        tbody tr.hide td i {
            width: 0;
            height: 0;
        }


        .status {
            margin-top: 10px;
            background-color: red;
            padding: .4rem 0;
            border-radius: 2rem;
            text-align: center;
        }

        .status.paid {
            background-color: #86e49d;
            color: #006b21;
        }

        .status.unpaid {
            background-color: #d893a3;
            color: #b30021;
        }

        @media (max-width: 1000px) {
            td:not(:first-of-type) {
                min-width: 7.1rem;
            }
        }

        .export_file {
            position: relative;
            ;
        }

        .export_file .export_file-btn {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            background: #fff6 url("assets/img/export.png") center / 80% no-repeat;
            border-radius: 50%;
            transition: .2s ease-in-out;
        }

        .export_file .export_file-btn:hover {
            background-color: #fff;
            transform: scale(1.15);
            cursor: pointer;
        }

        .export_file input {
            display: none;
        }

        .export_file .export_file-options {
            position: absolute;
            right: 0;
            width: 12rem;
            border-radius: .5rem;
            overflow: hidden;
            text-align: center;
            opacity: 0;
            transform: scale(.8);
            transform-origin: top right;
            box-shadow: 0 .2rem .5rem #0004;
            transition: .2s ease-in-out;
        }

        .export_file input:checked+.export_file-options {
            opacity: 1;
            transform: scale(1);
            z-index: 100;
        }

        .export_file .export_file-options label {
            display: block;
            width: 100%;
            padding: .6rem 0;
            background-color: #f2f2f2;
            display: flex;
            justify-content: space-around;
            align-items: center;
            transition: .2s ease-in-out;
        }

        .export_file .export_file-options label:first-of-type {
            padding: 1rem 0;
            background-color: #86e49d !important;
        }

        .export_file .export_file-options label:hover {
            transform: scale(1.05);
            background-color: #fff;
            cursor: pointer;

        }

        .export_file .export_file-options i {
            height: auto;
            width: 2rem;
        }
    </style>
</head>

<body>
    <main class="table" id="subsidy_table">
        <section class="table_header">
            <h1>Subsidy List</h1>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
            <div class="input-group">
                <input type="search" placeholder="Search" style="margin-left:50px">
                <!-- <img src="assets/img/s.png" alt="no img"> -->
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="export_file">
                <label for="export_file" class="export_file-btn" title="Export File"></label>
                <input type="checkbox" id="export_file">
                <div class="export_file-options">
                    <label>Export as &nbsp; &#10140; </label>
                    <label for="export_file" id="toExcel">Excel <i class="fa-regular fa-file-excel"></i> </label>
                </div>
            </div>
        </section>
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>Sl No </th>
                        <th>Particulars</th>
                        <th>Units</th>
                        <th>NDP</th>
                        <th>Mrp</th>
                        <th>STOCKS </th>
                        <!-- <th>Goverment share</th>
                        <th>Total</th>
                        <th>Status</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $sql = "SELECT * FROM stocks";
                    $result = $con->query($sql);
                    $counter = 0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo "<td>" . ++$counter . "</td>";
                            echo "<td>{$row['particulars']}</td>";
                            echo "<td>{$row['units']}</td>";
                            echo "<td>{$row['ndp']}</td>";
                            echo "<td>{$row['mrp']}</td>";
                            echo "<td>{$row['stocks']}</td>";

                            echo '<td>';
                            echo '<i class="fa-regular fa-pen-to-square" style="color: green; margin-right: 20px; cursor: pointer;" data-id="' . $row['sno'] . '" onclick="editRecord(' . $row['sno'] . ')"></i>';
                            echo '<i id="deleteIcon_' . $row['sno'] . '" class="fa-solid fa-trash-can" style="color: #e01a1a; cursor: pointer;" data-id="' . $row['sno'] . '" onclick="deleteRecordstock(' . $row['sno'] . ')"></i>';
                            echo '</td>';
                            echo "</tr>";

                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                </tbody>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {

                        function exportToExcel() {
                            var table = document.querySelector("table");

                            var tableClone = table.cloneNode(true);
                            var headerRow = tableClone.querySelector("thead tr");
                            var actionsColumnIndex = Array.from(headerRow.children).findIndex(cell => cell.textContent.trim() === "Actions");

                            if (actionsColumnIndex !== -1) {
                                Array.from(tableClone.querySelectorAll("tr")).forEach(row => row.children[actionsColumnIndex].remove());
                            }

                            var ws = XLSX.utils.table_to_sheet(tableClone);
                            var wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                            var filename = "subsidy_list.xlsx";
                            XLSX.writeFile(wb, filename);
                        }

                        var exportBtn = document.getElementById("toExcel");
                        exportBtn.addEventListener("click", exportToExcel);

                        var tableRows = document.querySelectorAll(".table-row-link");
                        tableRows.forEach(function (row) {
                            row.addEventListener("click", function () {
                                var href = this.getAttribute("data-href");
                                window.location.href = href;
                            });
                        });

                    });

                    function editRecord(id) {
                        window.location.href = "stockupdate.php?id=" + id;
                    }

                    function deleteRecordstock(id) {
                        if (confirm("Are you sure you want to delete this record?")) {
                            $.ajax({
                                url: './ajax/delete_recordstock.php',
                                method: "POST",
                                data: {
                                    id: id
                                },
                                success: function (res) {
                                    alert(res);
                                    location.reload();
                                },
                                error: function (err) {
                                    console.error(err);
                                }
                            });
                        }
                    }


                </script>
            </table>
        </section>
    </main>

    <script src="subsidylist.js"></script>

</body>

</html>