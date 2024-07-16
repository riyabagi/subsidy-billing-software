<?php
// session_start();
// $uid = $_SESSION['uid'];

// if (!$uid) {
//     header("Location: index.php");
//     exit();
// }
include("link.php");
include "footer.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body1 {
            width: 100%;
            /* background: #E5E7EB; */
            position: relative;
            display: flex;
            height: 100vh;
            /* background: url(assets/img/8.jpg) center / cover; */
        }


        main.table {
            margin: 20px;
            width: calc(100% - 100px);
            height: 95vh;
            background-color: #0077B5;
            backdrop-filter: blur(7px);
            box-shadow: 0 .4rem .8rem #0005;
            border-radius: .8rem;
            overflow: hidden;
        }

        #menu .logo {
            display: flex;
            align-items: center;
            /* color: #000000; */
            padding: 30px 0 0 30px;
        }

        #menu {
            background: #3a7ca5;
            width: 300px;
            height: 100vh;

        }

        #menu .items {
            margin-top: 40px;
        }


        #menu .items ul {
            list-style: none;
            padding: 0;
            /* margin: 20px; */
        }

        #menu .items li {
            list-style: none;
            padding: 15px 0px;
            transition: 0.3s;
            padding-left: 20px;
        }

        #menu .items li:hover {
            background: #9298a8;
            cursor: pointer;

            /* background: white; */
            color: black;
        }


        #menu .items li i {
            color: rgb(71, 84, 109);
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 14px;
            margin: 0 10px 10px 25px;
        }


        #menu .items li:hover i,
        #menu .items li:hover a {
            color: black;

        }

        #menu .items li a {
            text-decoration: none;
            color: rgb(239, 243, 250);
            font-weight: 300px;
            transition: 0.3s;
            padding-left: 20px;
        }

        .i-name {
            color: #444a53;
            padding: 20px 20px 0 30px;
            font-size: 24px;
            font-weight: 700;

        }

        /* .items li.active {
        background-color: #9298a8
    } */

        #menu .items .dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
            position: absolute;
            background-color: #0077B5;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
            z-index: 1;
            width: 15.6%;
        }

        #menu .items li:hover .dropdown-menu {
            display: block;
        }

        #menu .items .dropdown-menu li {
            padding: 15px 20px;
            transition: 0.3s;
        }

        #menu .items .dropdown-menu li:hover {
            background-color: #005689;
        }

        #menu .items .dropdown-menu a {
            text-decoration: none;
            color: rgb(239, 243, 250);
            font-weight: 300px;
            transition: 0.3s;
            display: block;
        }

        #menu .items .dropdown-menu a:hover {
            color: #fff;
        }

        .hamburger-icon {
            cursor: pointer;
        }

        @media screen and (min-width: 1020px) {
            .hamburger-icon {
                display: none;
            }

            #menu {
                display: block;
            }
        }

        @media screen and (max-width: 1020px) {
            #menu {
                display: none;
            }

            #menu.show-menu {
                display: block;
            }
        }


        /* @media screen and (min-width: 421px) and (max-width: 920px) {
            .hamburger-icon i {
                display: block;
            }
        } */

        /* @media screen and (min-width: 921px) {
            .hamburger-icon i {
                display: none;
            }
        } */
    </style>
</head>

<body>


    <div class="body1">
        <div class="col-md-3" style="flex: initial;">

            <div class="hamburger-icon" onclick="toggleMenu()">
                <i class="fa-solid fa-bars" style=" padding: 10px;"></i>
            </div>

            <section id="menu">
                <h3 style="padding-top:40px; margin-left:10px; font-weight:bold; font-size:25px; color:white; ">SHIVASHAKTI TRADERS</h3>
                <div class="items">
                    <li id="dashboard" class="dashboard" active>
                        <i class="fa-solid fa-dashboard" style="color:white;"></i><a href="dashboard.php"
                            style="margin-left: 5px;">Dashboard</a>
                    </li>
                    <li id="accounts" class="accounts" active>
                        <i class="fa-solid fa-users" style="color:white;"></i><a href="accoutn.php" style="margin-left: 5px;">Accounts</a>
                    </li>
                    <li id="stock" class="stock" active>
                        <i class="fa-solid fa-cubes" style="color:white;"></i><a href="stock.php" style="margin-left: 5px;">Stock</a>
                        <ul class="dropdown-menu" id="billsSubMenu" >
                            <li><a href="import1.php">Import Stocks</a></li>
                            <li><a href="showstocks.php">Stocks List</a></li>
                        </ul>
                    </li>
                    <li id="subsidy" class="subsidy">
                        <i class="fa-solid fa-money-bill-wheat" style="color:white;"></i> <a href="subsidy.php"
                            style="margin-left: 5px;">Subsidy</a>
                    </li>
                    <li id="subslist" class="subslist ">
                        <i class="fa-solid fa-table-list" style="color:white;"></i></i> <a href="subsidylist.php"
                            style="margin-left: 5px;">Subsidy
                            List</a>
                    </li>
                    <li id="bills" class="bills">
                        <i class="fa-solid fa-file-invoice"  style="color:white;"style="padding-right: 10px;"></i>
                        <a href="#" id="billsDropdown" style="margin-left:5px"> Bills</a>
                        <ul class="dropdown-menu" id="billsSubMenu" >
                            <li><a href="billin.php">Bill Inward</a></li>
                            <li><a href="billoutword.php">Bill Outward</a></li>
                            <li><a href="billoutwordlist.php">Bill Outward List</a></li>
                        </ul>
                    </li>
                    <script>
                        function toggleBillDropdown() {
                            var billsSubMenu = document.getElementById("billsSubMenu");
                            billsSubMenu.style.display = (billsSubMenu.style.display === "block") ? "none" : "block";
                        }
                    </script>
                    <li id="credit" class="credit">
                        <i class="fa-solid fa-credit-card" style="color:white;"></i><a href="credit.php" style="margin-left: 5px;">Credit</a>
                    </li>

                    <li id="report" class="report">
                        <i class="fa-solid fa-right-to-bracket" style="color:white;"></i>
                        <a href="#" style="margin-left: 5px;" >Report</a>
                        <ul class="dropdown-menu">
                            <li><a href="subsidyreport.php?type=subsidy">Subsidy</a></li>
                            <li><a href="creditsreport.php?type=credits">Credits</a></li>
                            <li><a href="outwardreport.php?type=bill-outward">Bill Outward</a></li>
                            <li><a href="stockreport.php?type=stock">Stock</a></li>
                        </ul>
                    </li>

                    <li id="logout"><i class="fa-solid fa-right-from-bracket" style="color:white;"></i> <a href="logout.php"
                            style="margin-left: 5px;">Logout</a>
                    </li>
                </div>
                <?php
                include("footer.php");
                ?>
            </section>
        </div>

        <script>
            function toggleMenu() {
                var menu = document.getElementById("menu");
                menu.classList.toggle("show-menu");
            }
        </script>
</body>
</html>